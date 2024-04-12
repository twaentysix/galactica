<?php

// Include the ShipDefinition and BattleAlgorithm classes
require_once 'ships.class.php';
require_once 'battle_algorithm.class.php';
require_once 'fleet.class.php';

// Define a class for the battle
class Battle {
    // Method to start the battle
    public static function startBattle(Fleet $playerFleet, Fleet $pirateFleet): void {
        // Simulate battle
        $playerWins = BattleAlgorithm::simulateBattle($playerFleet, $pirateFleet);

        // Output result
        if ($playerWins === true) {
            echo "Player wins!\n";
        } elseif ($playerWins === false) {
            echo "Pirates win!\n";
        } else {
            echo "The battle ends in a draw!\n";
        }
    }
}

// Define fleet objects for player and pirates
$playerFleet = new Fleet("Player Fleet", [
    new Ship("Transporter", 100000, 1, 1, 20, 50),
    new Ship("Light Fighter", 10000, 5, 5, 50, 100),
    new Ship("Heavy Fighter", 1000, 10, 10, 30, 80),
    new Ship("Cruiser", 100, 20, 20, 20, 60),
    new Ship("Battleship", 1, 50, 50, 10, 40)
]);

$pirateFleet = new Fleet("Pirate Fleet", [
    new Ship("Transporter", 100, 1, 1, 15, 40),
    new Ship("Light Fighter", 1000, 5, 5, 45, 90),
    new Ship("Heavy Fighter", 100, 10, 10, 25, 70),
    new Ship("Cruiser", 10, 20, 20, 15, 50),
    new Ship("Battleship", 5, 50, 50, 5, 30)
]);

// Start the battle
Battle::startBattle($playerFleet, $pirateFleet);

?>
