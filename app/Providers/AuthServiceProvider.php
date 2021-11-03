<?php

namespace App\Providers;

use App\Models\Faculty;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
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
        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });


        Gate::define('view-schedule', function($user, Faculty $faculty){
            return optional($user->faculty)->id == $faculty->id || $user->hasRole('admin');
        });


    }
}
