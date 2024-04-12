<?php
// Include the Ship and Fleet classes
require_once 'ships.class.php';
require_once 'fleet.class.php';

class ExpeditionManager {
    // Method to start an expedition
    public static function startExpedition(Fleet $fleet, int $numTroops): void {
        // Randomly generate resources
        $resources = self::generateResources($numTroops);

        // Apply resources to the fleet
        self::applyResourcesToFleet($fleet, $resources);

        // Output expedition result
        echo "Expedition completed!\n";
        echo "Resources gathered:\n";
        foreach ($resources as $resource => $amount) {
            echo "- $resource: $amount\n";
        }
    }

    // Method to generate resources based on the number of troops
    private static function generateResources(int $numTroops): array {
        $resources = ['Metal' => 0, 'Crystal' => 0, 'Fuel' => 0];

        // Randomly generate resources based on the number of troops
        $resources['Metal'] = rand(1, $numTroops);
        $resources['Crystal'] = rand(1, $numTroops);
        $resources['Fuel'] = rand(1, $numTroops);

        return $resources;
    }

    // Method to apply resources to the fleet
    private static function applyResourcesToFleet(Fleet $fleet, array $resources): void {
        foreach ($fleet->ships as $ship) {
            // Apply resources based on ship's attributes
            $ship->lifePoints += $resources['Metal'] * 100; // Assuming 1 Metal increases lifePoints by 100
            $ship->armor += $resources['Crystal'] * 2; // Assuming 1 Crystal increases armor by 2
            $ship->speed += $resources['Fuel'] * 5; // Assuming 1 Fuel increases speed by 5
        }
    }

    // Method to trigger battle with pirates
    public static function triggerPirateBattle(Fleet $fleet): void {
        // Create pirate fleet
        $pirateFleet = self::generatePirateFleet();

        // Start battle
        Battle::startBattle($fleet, $pirateFleet);
    }

    // Method to generate a pirate fleet for battle
    private static function generatePirateFleet(): Fleet {
        // Define pirate fleet
        $pirateFleet = new Fleet("Pirate Fleet", [
            new Ship("Transporter", 100, 1, 1, 15, 40),
            new Ship("Light Fighter", 1000, 5, 5, 45, 90),
            new Ship("Heavy Fighter", 100, 10, 10, 25, 70),
            new Ship("Cruiser", 10, 20, 20, 15, 50),
            new Ship("Battleship", 5, 50, 50, 5, 30)
        ]);

        return $pirateFleet;
    }
}

// Define fleet objects for player
$playerFleet = new Fleet("Player Fleet", [
    new Ship("Transporter", 100000, 1, 1, 20, 50),
    new Ship("Light Fighter", 10000, 5, 5, 50, 100),
    new Ship("Heavy Fighter", 1000, 10, 10, 30, 80),
    new Ship("Cruiser", 100, 20, 20, 20, 60),
    new Ship("Battleship", 1, 50, 50, 10, 40)
]);

// Start expedition with a certain number of troops
ExpeditionManager::startExpedition($playerFleet, 1000);

// Optionally, trigger pirate battle based on certain conditions
if (rand(0, 1) === 1) {
    ExpeditionManager::triggerPirateBattle($playerFleet);
}
?>
