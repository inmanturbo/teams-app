<?php

namespace App\Providers;

use App\Models\ConnectedAccount;
use App\Models\Link;
use App\Models\Membership;
use App\Models\Team;
use App\Policies\ConnectedAccountPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        Link::class => \App\Policies\LinkPolicy::class,
        Membership::class => \App\Policies\MembershipPolicy::class,
        ConnectedAccount::class => ConnectedAccountPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
