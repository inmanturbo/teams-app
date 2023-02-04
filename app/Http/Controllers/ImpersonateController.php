<?php

namespace App\Http\Controllers;

use App\Contracts\UpdatesCurrentTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Lab404\Impersonate\Controllers\ImpersonateController as Lab404ImpersonateController;

class ImpersonateController extends Lab404ImpersonateController
{
    /**
     * @param int         $id
     * @param string|null $guardName
     * @return  RedirectResponse
     * @throws  \Exception
     */
    public function take(Request $request, $id, $guardName = null)
    {
        $team = $request->user()->currentTeam;
        $userToImpersonate = $this->manager->findUserById($id, $guardName);
        $membership = \App\Charter::membershipInstance($team, $userToImpersonate);
        if (Gate::denies('impersonate', $membership)) {
            abort(403);
        }

        $updater = app(UpdatesCurrentTeam::class);

        $updater->update($userToImpersonate, ['team_uuid' => $team->uuid]);

        return parent::take($request, $id, $guardName);
    }
}
