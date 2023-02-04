<?php

namespace App\Models;

use Closure;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Sushi\Sushi;

abstract class SushiBase extends Model
{
    use HasFactory;
    use Sushi;

    public $timestamps = true;
  
    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    // protected function sushiConnectionConfig()
    // {
    //     return array_merge(config('database.connections.team'), ['prefix' => 'sushi_', 'name' => 'team']);
    // }
    
    protected function sushiShouldCache()
    {
        return true;
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        if (! isset($this->table)) {
            $needles = ['/', "\00", '\\', '.', '@', ':', '$', '-'];

            return str_replace($needles, '_', Str::snake(class_basename((new static)), '_'));
        }

        return $this->table;
    }

    protected static function cacheFileName()
    {
        $uuid = isset(app()['team']) ? app('team')->uuid : 'global';

        return config('sushi.cache-prefix', 'sushi').'-'.$uuid.'-'.Str::kebab(str_replace(['/', "\00", '\\'], ' ', static::class)).'.sqlite';
    }

    protected static function cacheDirectory()
    {
        return realpath(config('sushi.cache-path', storage_path('framework/cache')));
    }

    protected static function cacheFilePath()
    {
        return static::cacheDirectory().'/'. static::cacheFileName();
    }

    public static function getCacheFilePath()
    {
        return static::cacheFilePath();
    }

    public static function bootSushi()
    {
        $instance = (new static);

        $cacheFileName = static::cacheFileName();
        $cacheDirectory = static::cacheDirectory();
        $cachePath = static::getCacheFilePath();
        $dataPath = $instance->sushiCacheReferencePath();

        $databaseConfig = method_exists($instance, 'sushiConnectionConfig') ? $instance->sushiConnectionConfig() : [
            'driver' => 'sqlite',
            'database' => $cachePath,
        ];

        $states = [
            'cache-file-found-and-up-to-date' => function () use ($databaseConfig, $instance) {
                static::setDatabaseConnection($databaseConfig);
                if (! static::resolveConnection()->getSchemaBuilder()->hasTable($instance->getTable())) {
                    $instance->migrate();
                }
            },
            'cache-file-not-found-or-stale' => function () use ($cachePath, $databaseConfig, $dataPath, $instance) {
                file_put_contents($cachePath, '');

                static::setDatabaseConnection($databaseConfig);

                $instance->migrate();

                touch($cachePath, filemtime($dataPath));
            },
            'no-caching-capabilities' => function () use ($instance) {
                static::setDatabaseConnection([
                    'driver' => 'sqlite',
                    'database' => ':memory:',
                ]);

                $instance->migrate();
            },
        ];

        switch (true) {
            case ! $instance->sushiShouldCache():
                $states['no-caching-capabilities']();

                break;

            case file_exists($cachePath) && filemtime($dataPath) <= filemtime($cachePath):
                $states['cache-file-found-and-up-to-date']();

                break;

            case file_exists($cacheDirectory) && is_writable($cacheDirectory):
                $states['cache-file-not-found-or-stale']();

                break;

            default:
                $states['no-caching-capabilities']();

                break;
        }
    }

    protected static function setDatabaseConnection($config)
    {
        static::$sushiConnection = app(ConnectionFactory::class)->make($config);

        app('config')->set('database.connections.'.(new static)->getConnectionName(), $config);
    }

    protected function createTableSafely(string $tableName, Closure $callback)
    {
        /** @var \Illuminate\Database\Schema\SQLiteBuilder $schemaBuilder */
        $schemaBuilder = static::resolveConnection()->getSchemaBuilder();

        try {
            $schemaBuilder->dropIfExists($tableName);
            $schemaBuilder->create($tableName, $callback);
        } catch (QueryException $e) {
            if (Str::contains($e->getMessage(), 'already exists (SQL: create table')) {
                // This error can happen in rare circumstances due to a race condition.
                // Concurrent requests may both see the necessary preconditions for
                // the table creation, but only one can actually succeed.
                return;
            }

            throw $e;
        }
    }

    public function getConnectionName()
    {
        return str_replace('.', '-', (new static)->cacheFileName());
    }
}
