<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;

class CreateTeam implements CreatesTeams
{
    /**
     * Validate and create a new team for the given user.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return mixed
     */
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createTeam');

        AddingTeam::dispatch($user);

        $slug = $this->generateUniqueSlug($input['name']);

        $user->switchTeam($team = $user->ownedTeams()->create([
            'name' => $input['name'],
            'slug' => $slug,
            'personal_team' => false,
        ]));

        $user->current_team_id = $team->id;
        $user->save();

        $newTeamMember = Jetstream::findUserByEmailOrFail($user->email);

        $team->users()->attach(
            $newTeamMember, ['role' => 'admin']
        );

        return $team;
    }

    /**
     * Generate a unique slug for the team.
     *
     * @param  string  $name
     * @return string
     */
    protected function generateUniqueSlug($name)
    {
        $slug = slugify($name);
        $originalSlug = $slug;

        $i = 1;
        while (Jetstream::newTeamModel()->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . Str::random(5);
            $i++;
        }

        return $slug;
    }
}
