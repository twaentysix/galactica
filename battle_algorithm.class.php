<?php

// Define a class for ships
class Ship {
    // Properties
    public string $name;
    public int $lifePoints;
    public int $armor;
    public int $damage;

    // Constructor
    public function __construct(string $name, int $lifePoints, int $armor, int $damage) {
        $this->name = $name;
        $this->lifePoints = $lifePoints;
        $this->armor = $armor;
        $this->damage = $damage;
    }
}

// Define a class for fleets
class Fleet {
    // Properties
    public string $name;
    public array $ships;
    public int $totalLifePoints;

    // Constructor
    public function __construct(string $name, array $ships) {
        $this->name = $name;
        $this->ships = $ships;
        $this->calculateTotalLifePoints();
    }

    // Method to calculate total life points of the fleet
    public function calculateTotalLifePoints(): void {
        $this->totalLifePoints = 0;
        foreach ($this->ships as $ship) {
            $this->totalLifePoints += $ship->lifePoints;
        }
    }
}

// Define a class for the battle algorithm
class BattleAlgorithm {
    // Method to simulate a battle
    public static function simulateBattle(Fleet $playerFleet, Fleet $pirateFleet): ?bool {
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

// Define fleet objects for player and pirates
$playerFleet = new Fleet("Player Fleet", [
    new Ship("Transporter", 100000, 1, 1),
    new Ship("Light Fighter", 10000, 5, 5),
    new Ship("Heavy Fighter", 1000, 10, 10),
    new Ship("Cruiser", 100, 20, 20),
    new Ship("Battleship", 1, 50, 50)
]);

$pirateFleet = new Fleet("Pirate Fleet", [
    new Ship("Transporter", 100, 1, 1),
    new Ship("Light Fighter", 1000, 5, 5),
    new Ship("Heavy Fighter", 100, 10, 10),
    new Ship("Cruiser", 10, 20, 20),
    new Ship("Battleship", 5, 50, 50)
]);

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

?>
