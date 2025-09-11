<?php

namespace App\Providers;

use App\Models\Auth\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Property::class => \App\Policies\PropertyPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Définition des gates basées sur les permissions
        // foreach (Permission::all() as $permission) {
        //     Gate::define($permission->name, function ($user) use ($permission) {
        //         return $user->hasPermission($permission->name);
        //     });
        // }
    }
}
