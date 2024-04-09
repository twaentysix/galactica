<?php

// Include the ShipDefinition class
require_once 'ships.class.php';

// Define a class for the battle algorithm
class BattleAlgorithm {
    // Method to simulate a battle
    public static function simulateBattle(Fleet $playerFleet, Fleet $pirateFleet): ?bool {
        // Add some initial messages
        echo "Battle Begins!\n";

        while (true) {
            // Player's turn
            echo "Player's Turn:\n";
            if ($playerFleet->allShipsDestroyed()) {
                return false; // Player loses
            }
            $pirateTargetShip = $pirateFleet->ships[rand(0, count($pirateFleet->ships) - 1)];
            foreach ($playerFleet->ships as $playerShip) {
                if (!$playerShip->isDestroyed()) {
                    $playerShip->attack($pirateTargetShip);
                    if ($pirateTargetShip->isDestroyed()) {
                        echo "{$pirateTargetShip->name} is destroyed!\n";
                        $pirateFleet->calculateTotalAttributes(); // Recalculate total attributes
                    }
                }
            }

            // Pirate's turn
            echo "Pirate's Turn:\n";
            if ($pirateFleet->allShipsDestroyed()) {
                return true; // Player wins
            }
            $playerTargetShip = $playerFleet->ships[rand(0, count($playerFleet->ships) - 1)];
            foreach ($pirateFleet->ships as $pirateShip) {
                if (!$pirateShip->isDestroyed()) {
                    $pirateShip->attack($playerTargetShip);
                    if ($playerTargetShip->isDestroyed()) {
                        echo "{$playerTargetShip->name} is destroyed!\n";
                        $playerFleet->calculateTotalAttributes(); // Recalculate total attributes
                    }
                }
            }
        }
    }
}

?>
