<?php

namespace App\Actions\Jetstream;

use Laravel\Jetstream\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    /**
     * Delete the given team.
     *
     * @param  mixed  $team
     * @return void
     */
    public function delete($team)
    {

        $this->authorize('DELETE_TEAM_USR', $team->user_id);
        $team->purge();
    }
}
