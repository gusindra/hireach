<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;

class UpdateTeamName implements UpdatesTeamNames
{
    /**
     * Validate and update the given team's name.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  array  $input
     * @return void
     */
    public function update($user, $team, array $input)
    {
        Gate::forUser($user)->authorize('update', $team);

        // Sanitize and validate input
        $input = $this->sanitizeInput($input);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateTeamName');

        $team->forceFill([
            'name' => $input['name']
        ])->save();
    }

    /**
     * Sanitize input data.
     *
     * @param  array  $input
     * @return array
     */
    protected function sanitizeInput(array $input)
    {
        return [
            'name' => strip_tags(filterInput($input['name'])),
        ];
    }
}
