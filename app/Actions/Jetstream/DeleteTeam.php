<?php

namespace App\Actions\Jetstream;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Laravel\Jetstream\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    use AuthorizesRequests;
    /**
     * Delete the given team.
     *
     * @param  mixed  $team
     * @return void
     */
    public function delete($team)
    {
        $this->authorize('DELETE_TEAM', $team);
        $team->purge();
    }
}
