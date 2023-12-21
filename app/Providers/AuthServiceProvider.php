<?php

namespace App\Providers;

use App\Client;
use App\Journal;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $clientOwnershipCheck = function (User $user, Client $client) {
            return $user->id === $client->user_id;
        };

        Gate::define('view-client', $clientOwnershipCheck);
        Gate::define('delete-client', $clientOwnershipCheck);
        Gate::define('create-journal', $clientOwnershipCheck);

        $journalOwnershipCheck = function (User $user, Journal $journal) {
            return $user->id === $journal->client->user_id;
        };

        Gate::define('delete-journal', $journalOwnershipCheck);
    }
}
