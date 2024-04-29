<?php

namespace App\Http\Controllers;

use App\Models\Battles;
use App\Models\Fleets;

interface BattleController
{
    /**
     * Create a battle so it is saved into database and can be resolved later.
     * @param Fleets $fleet
     * @param Fleets $opponent
     * @return mixed
     */
    function create(Fleets $fleet, Fleets $opponent);

    /**
     * Resolve a battle and save outcome of it
     * @param Battles $battle
     * @return mixed
     */
    function resolve(Battles $battle);
}
