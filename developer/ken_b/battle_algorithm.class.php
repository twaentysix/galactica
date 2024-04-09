<?php

// Include the ShipDefinition class
require_once 'ships.class.php';

// Define a class for the battle algorithm
class BattleAlgorithm {
    // Method to simulate a battle
    public static function simulateBattle(array $playerShips, array $pirateShips): ?bool {
        // Add some initial messages
        echo "Battle Begins!\n";

        while (true) {
            // Player's turn
            echo "Player's Turn:\n";
            if (self::allShipsDestroyed($playerShips)) {
                return false; // Player loses
            }
            foreach ($playerShips as $playerShip) {
                if (!$playerShip->isDestroyed()) {
                    $targetShip = $pirateShips[rand(0, count($pirateShips) - 1)];
                    $playerShip->attack($targetShip);
                    if ($targetShip->isDestroyed()) {
                        echo "{$targetShip->name} is destroyed!\n";
                    }
                }
            }

            // Pirate's turn
            echo "Pirate's Turn:\n";
            if (self::allShipsDestroyed($pirateShips)) {
                return true; // Player wins
            }
            foreach ($pirateShips as $pirateShip) {
                if (!$pirateShip->isDestroyed()) {
                    $targetShip = $playerShips[rand(0, count($playerShips) - 1)];
                    $pirateShip->attack($targetShip);
                    if ($targetShip->isDestroyed()) {
                        echo "{$targetShip->name} is destroyed!\n";
                    }
                }
            }
        }
    }

    // Method to check if all ships in the array are destroyed
    private static function allShipsDestroyed(array $ships): bool {
        foreach ($ships as $ship) {
            if (!$ship->isDestroyed()) {
                return false;
            }
        }
        return true;
    }
}

?>
