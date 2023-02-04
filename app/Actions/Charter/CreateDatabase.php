<?php

namespace App\Actions\Charter;

use App\Aggregates\TeamDatabaseAggregate;
use App\Contracts\CreatesDatabase;
use App\Rules\DatabaseDoesNotExist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CreateDatabase implements CreatesDatabase
{
    public $teamDatabaseUuid;
    public $teamDatabaseName;

    /**
     * Validate and save the given model.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function create($user, array $input)
    {
        $nameRules = [
            'required',
            'string',
            'max:255',
            'min:3',
            'unique:landlord.team_databases',
            new DatabaseDoesNotExist,
        ];

        if (app()->environment('production')) {
            $nameRules[] = 'regex:/^[a-z0-9- _]+$/';
            $nameRules[] = 'not_in:test_database,test_database.sqlite,mysql,information_schema,performance_schema';
        }

        Validator::make($input, [
            'name' => $nameRules,
            'database_uuid' => ['nullable', 'unique:landlord.team_databases,uuid'],
        ])->validateWithBag('createDatabase');

        $uuid = $input['database_uuid'] ?? Str::uuid();

        $aggregate = TeamDatabaseAggregate::retrieve($uuid)
            ->createTeamDatabase($user->uuid, $input['name'])
            ->persist();
        
        $this->teamDatabaseUuid = $aggregate->uuid();
        $this->teamDatabaseName = $input['name'];
    }

    public function redirectTo()
    {
        session()->flash('flash.banner', __('Database created successfully.'));
        session()->flash('flash.bannerStyle', __('success'));

        return route('teams.create', ['team_database_uuid' => $this->teamDatabaseUuid, 'team_database_name' => $this->teamDatabaseName]);
    }
}
