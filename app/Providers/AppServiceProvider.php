<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Laravel\Sanctum\Sanctum;
use Laravel\Telescope\Telescope;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Telescope::ignoreMigrations();
        Cashier::ignoreMigrations();
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //if the config('app.url_scheme') is set to https, then we will force the scheme to be https
        if (config('app.url_scheme') === 'https') {
            \URL::forceScheme('https');
        }

        Blade::directive('alpine', function (string $variables) {
            return <<<DIRECTIVE
                <?php
                    \$data = array_combine(
                        array_map(
                            fn (\$variable) => str_replace('$', '', \$variable),
                            explode(',', '$variables')
                        ),
                        [$variables]
                    );
                    \$replaced = str_replace(["'", '"'], ["\'", "'"], json_encode(\$data));
                    if (str_starts_with(\$replaced, '{')) {
                        \$replaced = substr(\$replaced, 1);
                    }
                    if (str_ends_with(\$replaced, '}')) {
                        \$replaced = substr(\$replaced, 0, -1);
                    }
                    echo \$replaced;
                ?>
        DIRECTIVE;
        });
    }
}
