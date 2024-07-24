<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\Template;
use App\Policies\AdminPolicy;
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
        //
        Gate::define('update-post', [AdminPolicy::class, 'update']);
        Gate::define('update-post', [UserPolicy::class, 'update']);
    }
}
