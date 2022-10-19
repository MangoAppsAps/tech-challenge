<?php

namespace App\Providers;

use App\Booking;
use App\Client;
use App\Journal;
use App\Policies\BookingPolicy;
use App\Policies\ClientPolicy;
use App\Policies\JournalPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Client::class => ClientPolicy::class,
        Booking::class => BookingPolicy::class,
        Journal::class => JournalPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
