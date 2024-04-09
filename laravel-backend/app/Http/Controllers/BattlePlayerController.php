<?php

namespace App\Http\Controllers;

use App\Models\Harbours;
use App\Models\Fleets;
use Illuminate\Http\Request;

class BattlePlayerController extends BattleController
{
    public function simulateBattle(Fleets $attackerFleets, Harbours $defenderHarbour): ?bool {
        //TODO

        // Calculate total damage of player fleet
        $playerTotalDamage = 0;
        foreach ($playerFleet->ships as $playerShip) {
            $playerTotalDamage += $playerShip->damage;
        }

        // Calculate total damage of pirate fleet
        $pirateTotalDamage = 0;
        foreach ($pirateFleet->ships as $pirateShip) {
            $pirateTotalDamage += $pirateShip->damage;
        }

        // Introduce a random factor to add variability to the battle outcome
        $randomFactor = rand(0, 20); // Adjust range as needed

        // Apply random factor to each fleet's total life points
        $playerFleet->totalLifePoints += $randomFactor;
        $pirateFleet->totalLifePoints += $randomFactor;

        // Determine the winner based on total life points
        if ($playerFleet->totalLifePoints > $pirateFleet->totalLifePoints) {
            return true; // Player wins
        } elseif ($playerFleet->totalLifePoints < $pirateFleet->totalLifePoints) {
            return false; // Pirates win
        } else {
            return null; // Draw
        }
    }
}
