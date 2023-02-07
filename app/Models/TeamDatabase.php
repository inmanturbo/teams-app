<?php

namespace App\Models;

use App\Contracts\DatabaseManager;
use App\TeamDatabaseManagers\MySQLDatabaseManager;
use App\TeamDatabaseManagers\SQLiteDatabaseManager;
use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TeamDatabase extends Model
{
    use HasFactory;
    use UsesLandlordConnection;
    use BindsOnUuid;
    use GeneratesUuid;

    protected $guarded = [];

    protected $invalidCharacters = [
        '"', '~','!','@','#','$','%','^','&','*','(',')','-','+','=',';','/','','?','|',']','[','{','}','<','>','`','\\',' ', '\'',
    ];

    public function configure()
    {
        if (! app()->runningUnitTests()) {
            $connectionName = $this->driver === 'sqlite' ? 'team_sqlite' : 'team';

            switch ($this->driver) {
                case 'sqlite':
                    $databaseManager = new SQLiteDatabaseManager;

                    break;
                default:
                    $databaseManager = new MySQLDatabaseManager;

                    break;
            }

            config([
                'database.connections.'
                . $connectionName => $databaseManager
                    ->makeConnectionConfig(
                        config(
                            'database.connections.' . $connectionName
                        ),
                        $this->name
                    ),
                'database.default' => $connectionName,
            ]);
            
            DB::purge($connectionName);
            
            DB::connection($connectionName)->reconnect();
            
            Schema::connection($connectionName)->getConnection()->reconnect();
        }

        return $this;
    }

    public function use()
    {
        app()->forgetInstance('teamDatabase');

        app()->instance('teamDatabase', $this);

        return $this;
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function owner()
    {
        return $this->user;
    }

    public function name() : Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => $attributes['name'],
            set: fn ($value, $attributes) => $this->lowerSnakeSanitize($attributes['name'] ?? $value),
        );
    }

    public function lowerSnakeSanitize($name)
    {
        return str($name)->lower()->snake()->replace($this->invalidCharacters, '');
    }
}
