<?php

namespace App;

use App\Contracts\CreatesDatabase;
use App\Contracts\CreatesLink;
use App\Contracts\DatabaseManager;
use App\Contracts\DeletesLink;
use App\Contracts\MigratesTeamDatabase;
use App\Contracts\SubscribesByPromoCode;
use App\Contracts\UpdatesCurrentTeam;
use App\Contracts\UpdatesLink;
use App\Contracts\UpdatesTeamData;
use App\Contracts\UpdatesTeamDomains;
use App\Contracts\UpdatesTeamLandingPage;
use App\Contracts\UpdatesTeamLogo;
use App\Contracts\UpdatesUserType;
use App\Models\Membership;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class Charter
{
    /**
     * Register a class / callback that should be used to create a report.
     */
    public static function updateTeamLandingPageUsing(string $callback): void
    {
        app()->singleton(UpdatesTeamLandingPage::class, $callback);
    }

    /**
     * Register a class / callback that should be used to create a report.
     */
    public static function migrateTeamDatabasesUsing(string $callback): void
    {
        app()->singleton(MigratesTeamDatabase::class, $callback);
    }

    /**
     * Register a class / callback that should be used to create a database.
     */
    public static function updateTeamDataUsing(string $callback): void
    {
        app()->singleton(UpdatesTeamData::class, $callback);
    }

    /**
     * Register a class / callback that should be used to create a database.
     */
    public static function manageDatabasesUsing(string $callback): void
    {
        app()->singleton(DatabaseManager::class, $callback);
    }

    /**
     * Register a class / callback that should be used to create a database.
     */
    public static function createDatabasesUsing(string $callback): void
    {
        app()->singleton(CreatesDatabase::class, $callback);
    }

    /**
     * Register a class / callback that should be used to subscribe by promo code.
     */
    public static function subscribeByPromoCodeUsing(string $callback): void
    {
        app()->singleton(SubscribesByPromoCode::class, $callback);
    }

    /**
     * Register a class / callback that should be used to create a link.
     */
    public static function updateUserTypesUsing(string $callback): void
    {
        app()->singleton(UpdatesUserType::class, $callback);
    }

    /**
     * Register a class / callback that should be used to create a link.
     */
    public static function updateCurrentTeamsUsing(string $callback): void
    {
        app()->singleton(UpdatesCurrentTeam::class, $callback);
    }

    /**
     * Register a class / callback that should be used to create a link.
     */
    public static function createLinksUsing(string $callback): void
    {
        app()->singleton(CreatesLink::class, $callback);
    }

    /**
     * Register a class / callback that should be used to delete a link.
     */
    public static function deleteLinksUsing(string $callback): void
    {
        app()->singleton(DeletesLink::class, $callback);
    }

    /**
     * Register a class / callback that should be used to update team logo.
     */
    public static function updateTeamLogosUsing(string $callback): void
    {
        app()->singleton(UpdatesTeamLogo::class, $callback);
    }

    /**
     * Register a class / callback that should be used to update links.
     */
    public static function updateLinksUsing(string $callback): void
    {
        app()->singleton(UpdatesLink::class, $callback);
    }

    /**
     * Register a class / callback that should be used to update team logo.
     */
    public static function updateTeamDomainsUsing(string $callback): void
    {
        app()->singleton(UpdatesTeamDomains::class, $callback);
    }

    public static function currentTeam()
    {
        if (! isset(app()['team'])) {
            return false;
        }

        return once(fn () => app('team'));
    }

    public static function ensureTeamForUser(Request $request)
    {
        if (! $request->user() || ! $request->user()->currentTeam) {
            return;
        }

        $team = Team::where('uuid', $request->user()->currentTeam->uuid)->first();

        if (isset($team->uuid)) {
            session()->put('current_team_uuid', $team->uuid);
        }
    }

    public static function ensureTeamForDomain(Request $request)
    {
        $host = $request->getHost();

        if ($team = Team::where('domain', $host)->first()) {
            session()->put('current_team_uuid', $team->uuid);
        }
    }

    public static function membershipInstance(Team $team, User $user) : Membership
    {
        return new Membership([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);
    }
}
