<?php

namespace App\Models;

use App\AddressData;
use App\Concerns\HasLandingPage;
use App\TeamData;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam
{
    use HasFactory;
    use HasProfilePhoto;
    use UsesLandlordConnection;
    use HasLandingPage;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
    ];

    // protected $appends = [
    //     'url',
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    public function configure()
    {
        // if not testing
        if (! app()->runningUnitTests()) {
            config([
                'database.connections.team.database' => $this->teamDatabase->name ?? null,
            ]);
        }

        config([
            'cache.prefix' => $this->id,
            'team.logo_path' => $this->team_data->logoPath(),
            'team.name' => $this->team_data->name(),
            'team.phone' => $this->team_data->phone(),
            'team.fax' => $this->team_data->fax(),
            'team.street_address' => $this->team_data->streetAddress(),
            'team.city_state_zip' => $this->team_data->cityStateZip(),
            'team.email' => $this->team_data->email(),
        ]);

        DB::purge('team');

        DB::reconnect('team');

        Schema::connection('team')->getConnection()->reconnect();

        app('cache')->purge(
            config('cache.default')
        );

        return $this;
    }

    public function applyTeamScopeToUserBase()
    {
        User::addGlobalScope('team', function ($query) {
            $query->whereHas('teams', function ($query) {
                $query->where('teams.id', $this->id);
            });
            $query->orWhereHas('ownedTeams', function ($query) {
                $query->where('teams.id', $this->id);
            });
            $query->orWhereIn('email', $this->teamInvitations->pluck('email')->toArray());
        });
    }

    public function use()
    {
        app()->forgetInstance('team');

        app()->forgetInstance('team');

        app()->instance('team', $this);

        app()->instance('team_data', $this->team_data);

        return $this;
    }

    public function teamDatabase()
    {
        return $this->belongsTo(TeamDatabase::class);
    }

    public function landingPage()
    {
        $file = $this->teamData->landingPage() ?? config('team.landing_page');
    }

    public function url() : Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => isset($attributes['domain']) ? $this->preferHttps($attributes['domain']) : config('app.url'),
        );
    }

    public function teamData() : Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => $this->getTeamData($value, $attributes),
            set: fn ($value, $attributes) => json_encode($value),
        );
    }

    public function getTeamData($value, $attributes)
    {
        $teamData = json_decode($attributes['team_data'], true);
        $address = new AddressData(
            city: $teamData['address']['city'] ?? '',
            state:  $teamData['address']['state'] ?? '',
            zip: $teamData['address']['zip'] ?? '',
            street: $teamData['address']['street'] ?? '',
            country: $teamData['address']['country'] ?? 'USA',
            lineTwo: $teamData['address']['lineTwo'] ?? null,
        );

        return new TeamData(
            name: $this->name,
            landingPage: $teamData['landingPage'] ?? null,
            address: $address,
            logoUrl: $this->profile_photo_url,
            logoPath: $this->profile_photo_path ?? config('team.empty_logo_path'),
            phone: $teamData['phone'] ?? config('team.empty_phone'),
            fax: $teamData['fax'] ?? config('team.empty_phone'),
            email: $teamData['email'] ?? null,
            website: $teamData['website'] ?? null,
        );
    }

    //use  native laravel http client to check if domain supports https
    public function preferHttps($domain)
    {
        try {
            $response = Http::get("https://{$domain}");
            if ($response && $response->status() === 200) {
                return "https://{$domain}";
            }
        } catch (\Exception $e) {
        }

        return "http://{$domain}";
    }

    public function purge()
    {
        parent::purge();

        // delete all the links for this team
        $this->links()->delete();
        
        if (isset(app()['team']) && app()['team']->uuid === $this->uuid) {
            app()->forgetInstance('team');
            if (request()->user()->teams->count() > 0) {
                //switch to the first team
                request()->user()->switchTeam(request()->user()->teams->first());
                request()->user()->teams->first()->use();
            }
        }
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
