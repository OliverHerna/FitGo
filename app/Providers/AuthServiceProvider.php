<?php

namespace App\Providers;

use App\Paquete;
use App\Role;
use App\User;
use App\Benefit;
use App\Order;
use App\Client;
use App\PaqueteUser;
use App\Policies\UserPolicy;
use App\Policies\RolePolicy;
use App\Policies\PaquetePolicy;
use App\Policies\BenefitPolicy;
use App\Policies\ClientPolicy;
use App\Policies\PaqueteUserPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ReportPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Paquete::class => PaquetePolicy::class,
        Benefit::class => BenefitPolicy::class,
        Order::class => OrderPolicy::class,
        PaqueteUser::class => PaqueteUserPolicy::class,
        Client::class => ClientPolicy::class,
        Policy::class => ReportPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Users gates

        Gate::resource('users', 'App\Policies\UserPolicy');
        Gate::define('users.restore', 'App\Policies\UserPolicy@restore');
        Gate::define('users.forceDelete', 'App\Policies\UserPolicy@forceDelete');
        Gate::define('users.log', 'App\Policies\UserPolicy@log');
        Gate::define('users.index', 'App\Policies\UserPolicy@viewAny');

        // Roles gates

        Gate::resource('roles', 'App\Policies\RolePolicy');
        Gate::define('roles.restore', 'App\Policies\RolePolicy@restore');
        Gate::define('roles.forceDelete', 'App\Policies\RolePolicy@forceDelete');
        Gate::define('roles.index', 'App\Policies\RolePolicy@viewAny');

        // Paquetes gates
        Gate::resource('paquetes', 'App\Policies\PaquetePolicy');
        Gate::define('paquetes.index', 'App\Policies\PaquetePolicy@viewAny');

        // Beneficios Gates
        Gate::resource('benefits', 'App\Policies\BenefitPolicy');
        Gate::define('benefits.index', 'App\Policies\BenefitPolicy@viewAny');

        // Orders Gates
        Gate::resource('orders', 'App\Policies\OrderPolicy');
        Gate::define('order.index', 'App\Policies\OrderPolicy@viewAny');

        //PaqueteUsers Gates
        Gate::resource('paquete_users', 'App\Policies\PaqueteUserPolicy');
        Gate::define('storePaqueteUser', 'App\Policies\PaqueteUserPolicy@store');
        Gate::define('paquete_users.profile', 'App\Policies\PaqueteUserPolicy@profile');
        Gate::define('paquete_users.attach_package', 'App\Policies\PaqueteUserPolicy@storePackageClient');
        

        // Clients Gates
        Gate::resource('clients', 'App\Policies\ClientPolicy');
        Gate::define('client.index', 'App\Policies\ClientPolicies@viewAny');
        Gate::define('client.reports', 'App\Policies\ClientPolicies@report');

        // Reports Gates
        Gate::resource('reports', 'App\Policies\ReportPolicy');
        Gate::define('report.index', 'App\Policies\ReportPolicies@viewAny');

        // Configuration gates (delete this)

        Gate::define('configuration.edit', function (User $user) {
            $permission = $user->role->permissions()->whereHas('module', function ($query) {
                $query->where('name', 'Configuration');
            })->first();

            return filled($permission);
        });

        // Control panel gates

        Gate::define('control_panel', function (User $user) {
            $permission = $user->role->permissions()->whereHas('module', function ($query) {
                $query->whereIn('name', [
                    'User',
                    'Role',
                ]);
            })->first();

            return filled($permission);
        });

        Gate::define('user_panel', function (User $user) {
            $permission = $user->role->permissions()->whereHas('module', function ($query) {
                $query->whereIn('name', [
                    'User',
                    'Role',
                ]);
            })->first();

            return filled($permission);
        });

        //Paquetes Gates
        Gate::define('paquete_panel', function (User $user) {
            $permission = $user->role->permissions()->whereHas('module', function ($query) {
                $query->whereIn('name', [
                    'Paquete',
                ]);
            })->first();

            return filled($permission);
        });

        Gate::define('benefit_panel', function (User $user) {
            $permission = $user->role->permissions()->whereHas('module', function ($query) {
                $query->whereIn('name', [
                    'Benefit',
                ]);
            })->first();

            return filled($permission);
        });

        Gate::define('order_panel', function (User $user) {
            $permission = $user->role->permissions()->whereHas('module', function ($query) {
                $query->whereIn('name', [
                    'Order',
                ]);
            })->first();

            return filled($permission);
        });

        //Clients Panel
        Gate::define('client_panel', function (User $user) {
            $permission = $user->role->permissions()->whereHas('module', function ($query) {
                $query->whereIn('name', [
                    'Client',
                ]);
            })->first();

            return filled($permission);
        });

        //Reports Panel
        Gate::define('report_panel', function (User $user) {
            $permission = $user->role->permissions()->whereHas('module', function ($query) {
                $query->whereIn('name', [
                    'Report',
                ]);
            })->first();

            return filled($permission);
        });
    }
}