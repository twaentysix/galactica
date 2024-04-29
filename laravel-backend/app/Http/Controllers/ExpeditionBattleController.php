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
        $battle->opponent()->associate($opponent);
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

        $randomFactor = rand(0, 100);
        $modifiedFleetStrength = $fleetStrength + ($randomFactor * 0.5);
        $scalingFactor = $modifiedFleetStrength / $opponentStrength;
        $winningThreshold = 1 - ($opponentStrength / ($opponentStrength + $modifiedFleetStrength * $scalingFactor));
        $randomNumber = rand(0, 100) / 100;

        if ($randomNumber < $winningThreshold) {
            $won = true;
            $destructionMultiplier = (rand(5, 15) * (1/$winningThreshold));
        }
        else{
            $won = false;
            $destructionMultiplier = (rand(20, 40) * (1/$winningThreshold));
        }

        $destructionRate = (min(100, ($fleetStrength / ($fleetStrength + $opponentStrength)) * $destructionMultiplier)) / 100;
        $lostShips = $fleet->destroyShipsAfterBattle($destructionRate);
        $battle->update([
            'won' => $won,
            'lost_ships' => $lostShips,
            'finished' => true,
            'fleet_strength' => $fleetStrength,
            'opponent_strength' => $opponentStrength,
        ]);
        $battle->save();
    }

    function getPirateFleet(Fleets $fleet){
        $fleetStrength = $fleet->getBattleStrength();
        if($fleetStrength < 15000) {
            $fleet = Fleets::firstWhere('name', '=', 'Pirates_easy');
        }elseif ($fleetStrength < 30000) {
            $fleet = Fleets::firstWhere('name', '=', 'Pirates_medium');
        }else{
            $fleet = Fleets::firstWhere('name', '=', 'Pirates_hard');
        }
        return $fleet;
    }
}
