<?php

// Include the Ship class
require_once 'ships.class.php';

// Define a class for fleets
class Fleet {
    // Properties
    public string $name;
    public array $ships;
    public int $totalLifePoints;
    public int $totalArmor;
    public int $totalDamage;

    // Constructor
    public function __construct(string $name, array $ships) {
        $this->name = $name;
        $this->ships = $ships;
        $this->calculateTotalAttributes();
    }

    // Method to calculate total attributes of the fleet
    public function calculateTotalAttributes(): void {
        $this->totalLifePoints = 0;
        $this->totalArmor = 0;
        $this->totalDamage = 0;

        foreach ($this->ships as $ship) {
            $this->totalLifePoints += $ship->lifePoints;
            $this->totalArmor += $ship->armor;
            $this->totalDamage += $ship->damage;
        }
    }

    // Method to check if all ships in the fleet are destroyed
    public function allShipsDestroyed(): bool {
        foreach ($this->ships as $ship) {
            if (!$ship->isDestroyed()) {
                return false;
            }
        }
        return true;
    }
}

?>
