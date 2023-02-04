<?php

use App\Http\Controllers\CurrentTeamController as ControllersCurrentTeamController;
use App\Http\Controllers\TeamController as ControllersTeamController;
use App\Http\Controllers\TeamInvitationController as ControllersTeamInvitationController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Jetstream\Http\Controllers\Livewire\ApiTokenController;
use Laravel\Jetstream\Http\Controllers\Livewire\PrivacyPolicyController;
use Laravel\Jetstream\Http\Controllers\Livewire\TermsOfServiceController;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use Laravel\Jetstream\Jetstream;

Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
    if (Jetstream::hasTermsAndPrivacyPolicyFeature()) {
        Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])->name('terms.show');
        Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');
    }

    $authMiddleware = config('jetstream.guard')
            ? 'auth:'.config('jetstream.guard')
            : 'auth';

    Route::group(['middleware' => [$authMiddleware, 'team.auth', 'verified']], function () {
        Route::group(['middleware' => ['has_team']], function () {

            // User & Profile...
            Route::get('/user/profile', [UserProfileController::class, 'show'])
                    ->name('profile.show');

            // API...
            if (Jetstream::hasApiFeatures()) {
                Route::get('/user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
            }

            // Teams...
            if (Jetstream::hasTeamFeatures()) {
                Route::get('/teams/create', [ControllersTeamController::class, 'create'])->name('teams.create')->middleware('upgraded');
                Route::get('/create-first-team', [ControllersTeamController::class, 'createFirstTeam'])->name('create-first-team')->middleware('has_no_team');
                Route::get('/teams/{team}', [ControllersTeamController::class, 'show'])->name('teams.show');
                Route::put('/current-team', [ControllersCurrentTeamController::class, 'update'])->name('current-team.update')->can('updateTeam', User::class);
            }
        });
        // No team yet...
        if (Jetstream::hasTeamFeatures()) {
            Route::get('/team-invitations/{invitation:uuid}', [ControllersTeamInvitationController::class, 'accept'])
            ->middleware(['signed'])
            ->name('team-invitations.accept');

            Route::get('/create-first-team', [ControllersTeamController::class, 'createFirstTeam'])->name('create-first-team');

            Route::get('/join-team', [ControllersTeamController::class, 'joinTeam'])->name('join-team');

            Route::view('/billing', 'subscribe')->name('billing');
        }
    });
});
