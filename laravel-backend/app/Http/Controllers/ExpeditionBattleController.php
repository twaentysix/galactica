<?php

namespace App\Http\Controllers;

use App\Models\Battles;
use App\Models\Fleets;

class ExpeditionBattleController extends Controller implements BattleController
{
    function create(Fleets $fleet, Fleets $opponent)
    {
        $battle = Battles::create();
        $battle->fleet()->associate($fleet);
        $battle->fleet()->associate($fleet);
        $battle->save();
        return $battle;
    }

    function resolve(Battles $battle)
    {
        $fleet = $battle->fleet;

        $opponent = $battle->opponent;

        $fleetStrength = $fleet->getBattleStrength();
        $opponentBaseStrength = $opponent->getBattleStrength();

        // Calculate total strength of the second fleet
        $randomAdjustment = rand(0, $fleetStrength * 0.2); // Random adjustment proportional to the strength of the first fleet
        $opponentStrength = $opponentBaseStrength + $randomAdjustment;
        $destructionRate = min(100, ($fleetStrength / ($fleetStrength + $opponentStrength)) * 100);

        $randomFactor = rand(0, 100);
        $modifiedFleetStrength = $fleetStrength + ($randomFactor * 0.05);
        $winningThreshold = $opponentStrength / ($opponentStrength + $modifiedFleetStrength);
        $randomNumber = rand(0, 100) / 100;

        if ($randomNumber < $winningThreshold) {
            $won = true;
        }
        else{
            $won = false;
        }
        $lostShips = $fleet->destroyShipsAfterBattle($destructionRate);
        $battle->update([
            'won' => $won,
            'lost_ships' => $lostShips,
            'finished' => true,
        ]);
        $battle->save();
    }

    function getPirateFleet(Fleets $fleet){
        $fleetStrength = $fleet->getBattleStrength();
        if($fleetStrength < 1000) {
            $fleet = Fleets::firstWhere('name', '=', 'Pirates_easy');
        }elseif ($fleetStrength < 3000) {
            $fleet = Fleets::firstWhere('name', '=', 'Pirates_medium');
        }else{
            $fleet = Fleets::firstWhere('name', '=', 'Pirates_hard');
        }
        return $fleet;
    }
}
