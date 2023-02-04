<?php

namespace Database\Seeders;

use App\Aggregates\TeamAggregate;
use App\Aggregates\TeamDatabaseAggregate;
use App\Aggregates\UserAggregate;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeamMember;
use Laravel\Jetstream\Events\TeamMemberAdded;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $creator = app(CreatesNewUsers::class);
        $teamCreator = app(CreatesTeams::class);

        $owner = $creator->create([
            'name' => 'Owner',
            'email' => 'owner@mailinator.com',
            'password' => 'pa$$w0rd',
            'password_confirmation' => 'pa$$w0rd',
            'terms' => true,
        ]);

        UserAggregate::retrieve($owner->uuid)->updateUserType(UserType::SuperAdmin->value)->persist();

        $fakeFirstUuid = '00000000-0000-0000-0000-000000000000';
        $ownerDb = TeamDatabaseAggregate::retrieve($fakeFirstUuid)->createTeamDatabase(
            name: 'owner_db',
            driver: 'mysql',
            userUuid:  $owner->uuid,
        )->persist();

        $team = $teamCreator->create($owner->fresh(), [
            'name' => 'Owner Team',
            'team_database_uuid' => $fakeFirstUuid,
        ]);

        $ownerTeamMembers = [];

        $ownerTeamMembers['admin'] = $creator->create([
            'name' => 'Admin',
            'email' => 'admin@mailinator.com',
            'password' => 'pa$$w0rd',
            'password_confirmation' => 'pa$$w0rd',
            'terms' => true,
        ]);

        $ownerTeamMembers['supervisor'] = $creator->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@mailinator.com',
            'password' => 'pa$$w0rd',
            'password_confirmation' => 'pa$$w0rd',
            'terms' => true,
        ]);

        $ownerTeamMembers['workforce'] = $creator->create([
            'name' => 'Workforce',
            'email' => 'workforce@mailinator.com',
            'password' => 'pa$$w0rd',
            'password_confirmation' => 'pa$$w0rd',
            'terms' => true,
        ]);

        $ownerTeamMembers['client'] = $creator->create([
            'name' => 'client',
            'email' => 'client@mailinator.com',
            'password' => 'pa$$w0rd',
            'password_confirmation' => 'pa$$w0rd',
            'terms' => true,
        ]);

        // Add all the team members to the owner team
        foreach ($ownerTeamMembers as $role => $newTeamMember) {
            AddingTeamMember::dispatch($team, $newTeamMember);

            TeamAggregate::retrieve($team->uuid)->addMember(
                teamUuid: $team->uuid,
                email: $newTeamMember->email,
                role: $role,
            )->persist();

            $newTeamMember->switchTeam($team);

            TeamMemberAdded::dispatch($team, $newTeamMember);
        }
    }
}
