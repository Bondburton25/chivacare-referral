<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('isAdmin', fn($user) => $user->role === 'admin');
        Gate::define('isSuperAdmin', fn($user) => $user->role === 'super_admin');
        Gate::define('isOperator', fn($user) => $user->role === 'operator');
        Gate::define('isDoctor', fn($user) => $user->role === 'doctor');
        Gate::define('isNurse', fn($user) => $user->role === 'nurse');
        Gate::define('isPatient', fn($user) => $user->role === 'patient');
    }
}
