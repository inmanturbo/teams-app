<?php

namespace App\Providers;

use App\Repositories\FieldRepositoryInterface;
use App\Repositories\IconRepository;
use App\Repositories\IconRepositoryInterface;
use App\Repositories\MenuRepository;
use App\Repositories\MenuRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IconRepositoryInterface::class, IconRepository::class);
        $this->app->bind(MenuRepositoryInterface::class, MenuRepository::class);

        Str::macro('fromCamelCase', function ($input) {
            preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
            $ret = $matches[0];
            foreach ($ret as &$match) {
                $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
            }

            return implode('_', $ret);
        });

        $this->app->bind(TableRepositoryInterface::class, \App\Repositories\Repository::class);
        $this->app->bind(FieldRepositoryInterface::class, \App\Repositories\Repository::class);
    }
}
