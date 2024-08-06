<?php

namespace App\Actions\Fortify;

use App\Models\RoleInvitation;
use App\Models\RoleUser;
use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $registeruser = DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) {
                //$this->createTeam($user);
            });
        });

        if ($input['email'] && $registeruser) {
            $role = 'admin';
            $team = 0;
            $newTeamMember = Jetstream::findUserByEmailOrFail($input['email']);

            // ADMIN INVITATION
            $newInvitation = RoleInvitation::where('email', $input['email'])->first();
            if($newInvitation){
                $role = $newInvitation->role ? $newInvitation->role->name : 'admin';
                $roleUser = RoleUser::where('user_id', $newTeamMember->id)->count();
                if ($roleUser == 0) {
                    RoleUser::create([
                        'user_id' => $newTeamMember->id,
                        'role_id' => $newInvitation->role_id,
                        'team_id' => $newInvitation->team_id
                    ]);
                    $newTeamMember->update(['current_team_id' => $newInvitation->team_id]);
                }
                $newInvitation->delete();
            }
            // IF ADMIN INVITATION
            // ELSE USER TEAM INVITATION
            if($newInvitation && $newInvitation->team_id){
                $team = Team::find($newInvitation->team_id);
            }else{
                $newInvitation = TeamInvitation::where('email', $input['email'])->first();
                if($newInvitation){
                    $team = Team::find($newInvitation->team_id);
                    $newTeamMember->update(['reff_team_id'=>$newInvitation->team_id]);
                    $role = $newInvitation->role;
                    $newInvitation->delete();
                }
            }
            if($newInvitation && $team){
                $team->users()->attach(
                    $newTeamMember, ['role' => $role]
                );
            }
        }

        return $registeruser;
    }


    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Chat Team",
            'personal_team' => true,
        ]));
    }
}
