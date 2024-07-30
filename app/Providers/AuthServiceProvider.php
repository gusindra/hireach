<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Team;
use App\Models\Template;
use App\Models\User;
use App\Policies\AdminPolicy;
use Illuminate\Support\Facades\Auth;
use App\Policies\TeamPolicy;
use App\Policies\TemplatePolicy;
use App\Policies\UserPolicy;
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
        Team::class => TeamPolicy::class,
        Template::class => TemplatePolicy::class,
        User::class => UserPolicy::class


    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerPolicies();
        Gate::define('update-template', [TemplatePolicy::class, 'update']);
        Gate::define('VIEW_ANY_CHAT_USR', [UserPolicy::class, 'viewAny']);
        Gate::define('DELETE_TEAM', [TeamPolicy::class, 'delete']);

        $per = cache()->remember('permissions', 1440, function () {
            return Permission::all();
        });


        foreach ($per as $p) {

            if ($p->for === 'admin') {
                if (stripos($p->name, "CREATE") !== false) {
                    Gate::define(str_replace(" ", "_", $p->name), [AdminPolicy::class, "create"]);
                } elseif (stripos($p->name, "UPDATE") !== false) {
                    Gate::define(str_replace(" ", "_", $p->name), [AdminPolicy::class, "update"]);
                } elseif (stripos($p->name, "DELETE") !== false) {
                    Gate::define(str_replace(" ", "_", $p->name), [AdminPolicy::class, "delete"]);
                } elseif (stripos($p->name, "VIEW") !== false) {
                    Gate::define(str_replace(" ", "_", $p->name), [AdminPolicy::class, "view"]);
                }
            }

            if (stripos($p->name, "CREATE") !== false) {
                Gate::define(str_replace(" ", "_", $p->name) . "_" . "USR", [UserPolicy::class, "create"]);
            } elseif (stripos($p->name, "UPDATE") !== false) {
                Gate::define(str_replace(" ", "_", $p->name) . "_" . "USR", [UserPolicy::class, "update"]);
            } elseif (stripos($p->name, "DELETE") !== false) {
                Gate::define(str_replace(" ", "_", $p->name) . "_" . "USR", [UserPolicy::class, "delete"]);
            } elseif (stripos($p->name, "VIEW") !== false) {
                Gate::define(str_replace(" ", "_", $p->name) . "_" . "USR", [UserPolicy::class, "view"]);
            } elseif (stripos($p->name, "DELETE") !== false) {
                Gate::define(str_replace(" ", "_", $p->name) . "_" . "USR", [TeamPolicy::class, "delete"]);
            }

        }





    }
}
