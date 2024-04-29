<?php
// Include the Ship and Fleet classes
require_once 'ships.class.php';
require_once 'fleet.class.php';

class ExpeditionManager {
    // Method to start an expedition
    public static function startExpedition(Fleet $fleet, int $numTroops): void {
        // Randomly generate resources for each ship in the fleet
        foreach ($fleet->ships as $ship) {
            $resourcesFound = self::generateResourcesForShip($ship, $numTroops);
            self::applyResourcesToShip($ship, $resourcesFound);
        }

        // Output expedition result
        echo "Expedition completed!\n";
        echo "Resources gathered:\n";
        foreach ($fleet->ships as $ship) {
            echo "$ship->name found:\n";
            foreach ($ship->resourcesFound as $resource => $amount) {
                echo "- $resource: $amount\n";
            }
        }
    }

    private static function generateResourcesForShip(Ship $ship, int $numTroops): array {
        $resourcesFound = ['Metal' => 0, 'Crystal' => 0, 'Fuel' => 0];

        // Define probability of finding each resource based on ship's class
        $metalProbability = $ship->lifePoints / $numTroops; // Adjust as needed
        $crystalProbability = $ship->armor / $numTroops; // Adjust as needed
        $fuelProbability = $ship->speed / $numTroops; // Adjust as needed

        // Generate random numbers to determine which resources are found
        if (rand(0, $numTroops) <= $metalProbability) {
            $resourcesFound['Metal'] = rand(1, $numTroops);
        }
        if (rand(0, $numTroops) <= $crystalProbability) {
            $resourcesFound['Crystal'] = rand(1, $numTroops);
        }
        if (rand(0, $numTroops) <= $fuelProbability) {
            $resourcesFound['Fuel'] = rand(1, $numTroops);
        }

        return $resourcesFound;
    }


    // Method to trigger battle with pirates
    public static function triggerPirateBattle(Fleet $fleet): void {
        // Create pirate fleet
        $pirateFleet = self::generatePirateFleet();

        // Start battle
        Battle::startBattle($fleet, $pirateFleet);
    }

    private static function applyResourcesToShip(Ship $ship, array $resourcesFound): void {
        // Store the resources found on the ship
        $ship->resourcesFound = $resourcesFound;
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
