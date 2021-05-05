<?php

namespace App\Providers;

use App\Models\Application;
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

        Gate::before(function ($user) {
            if ($user->isAdministrator()) {
                return true;
            }
        });
        
        Gate::define('create-application', function($user){
            $roles = array_column($user->roles->toArray(), 'role');
            if(count(array_intersect([env('ROLE_EMPLOYEE', '')], $roles)) > 0){
                return true;
            }
            return false;
        });

        Gate::define('move-application', function($user){
            $roles = array_column($user->roles->toArray(), 'role');
            if(count(array_intersect([env('ROLE_ADMIN_APPS', '')], $roles)) > 0){
                return true;
            }
            return false;
        });

        Gate::define('approve-charity', function($user){
            $roles = array_column($user->roles->toArray(), 'role');
            if(count(array_intersect([env('ROLE_ADMIN', '')], $roles)) > 0){
                return true;
            }
            return false;
        });

        Gate::define('view-reports', function($user){
            $roles = array_column($user->roles->toArray(), 'role');
            if(count(array_intersect([env('ROLE_ADMIN_REPORTS', '')], $roles)) > 0){
                return true;
            }
            return false;
        });

    }
}
