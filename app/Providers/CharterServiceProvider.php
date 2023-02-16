<?php

namespace App\Providers;

use App\Actions\Charter\ArtisanTeamDatabaseMigrate;
use App\Actions\Charter\CreateDatabase;
use App\Actions\Charter\CreateLink;
use App\Actions\Charter\DeleteLink;
use App\Actions\Charter\SubscribeByPromoCode;
use App\Actions\Charter\UpdateCurrentTeam;
use App\Actions\Charter\UpdateLink;
use App\Actions\Charter\UpdateTeamData;
use App\Actions\Charter\UpdateTeamDomain;
use App\Actions\Charter\UpdateTeamLandingPage;
use App\Actions\Charter\UpdateTeamLogo;
use App\Actions\Charter\UpdateUserType;
use App\Charter;
use App\TeamDatabaseManagers\MySQLDatabaseManager;
use App\TeamDatabaseManagers\SQLiteDatabaseManager;
use Illuminate\Support\ServiceProvider;

class CharterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Charter::updateTeamLandingPageUsing(UpdateTeamLandingPage::class);
        Charter::migrateTeamDatabasesUsing(ArtisanTeamDatabaseMigrate::class);
        Charter::updateTeamDataUsing(UpdateTeamData::class);
        Charter::manageDatabasesUsing($this->getDatabaseManager());
        Charter::createDatabasesUsing(CreateDatabase::class);
        Charter::subscribeByPromoCodeUsing(SubscribeByPromoCode::class);
        Charter::updateUserTypesUsing(UpdateUserType::class);
        Charter::updateCurrentTeamsUsing(UpdateCurrentTeam::class);
        Charter::updateTeamLogosUsing(UpdateTeamLogo::class);
        Charter::updateTeamDomainsUsing(UpdateTeamDomain::class);
        Charter::createLinksUsing(CreateLink::class);
        Charter::updateLinksUsing(UpdateLink::class);
        Charter::deleteLinksUsing(DeleteLink::class);
    }

    protected function getDatabaseManager()
    {
        $teamDatabaseDriver = config(
            'database.connections.'
            .config('team.db_connection', 'team')
            .'.driver'
        );

        if (! $teamDatabaseDriver) {
            throw new \Exception('No team database driver defined');
        }

        switch ($teamDatabaseDriver) {
            case 'mysql':
                return MySQLDatabaseManager::class;

                break;
            case 'sqlite':
                return SQLiteDatabaseManager::class;
            default:
                throw new \Exception("Unsupported database driver: {$teamDatabaseDriver}");
        }
    }
}
