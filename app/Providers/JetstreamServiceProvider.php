<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Contracts\CurentTeamResponse;
use App\Models\TeamUser;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(CurentTeamResponse::class, new class implements CurentTeamResponse {
            public function toResponse($request)
            {
                TeamUser::where('team_id', auth()->user()->currentTeam->id)->where('user_id', auth()->user()->id)->update([
                    'status' => 'Online'
                ]);

                $home = '/dashboard';

                return redirect()->intended($home);
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);

        $this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );

        $this->app->singleton(
            \Laravel\Fortify\Contracts\TwoFactorLoginResponse::class,
            \App\Http\Responses\TwoFactorLoginResponse::class
        );

        $this->app->singleton(
            \Laravel\Jetstream\Contracts\CurentTeamResponse::class,
            \App\Http\Responses\UpdateTeamResponse::class
        );
    }

    /**
     * Configure the roles and permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        // Jetstream::role('superadmin', __('Super'), [
        //     'create',
        //     'read',
        //     'update',
        //     'delete',
        // ])->description(__('Super users can perform any action.'));

        Jetstream::role('admin', __('Administrator'), [
            'create',
            'read',
            'update',
            'delete',
        ])->description(__('Administrator users can perform any action.'));

        // Jetstream::role('editor', __('Editor'), [
        //     'read',
        //     'create',
        //     'update',
        // ])->description(__('Editor users have the ability to read, create, and update.'));

        Jetstream::role('agen', __('Agen'), [
            'read',
            'create',
        ])->description(__('Agen users have the ability to read & response message .'));
    }
}
