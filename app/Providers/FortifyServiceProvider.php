<?php

namespace App\Providers;

use App\Actions\CreateNewUser as ActionsCreateNewUser;
use App\Actions\ResetUserPassword as ActionsResetUserPassword;
use App\Actions\UpdateUserPassword as ActionsUpdateUserPassword;
use App\Actions\UpdateUserProfileInformation as ActionsUpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(ActionsCreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(ActionsUpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(ActionsUpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ActionsResetUserPassword::class);

        Fortify::ignoreRoutes();

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
