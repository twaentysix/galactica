<?php

// Define a class for ships
class Ship {
    // Properties
    public string $name;
    public int $lifePoints;
    public int $armor;
    public int $damage;
    public int $speed;
    public int $range;

    // Constructor
    public function __construct(string $name, int $lifePoints, int $armor, int $damage, int $speed, int $range) {
        $this->name = $name;
        $this->lifePoints = $lifePoints;
        $this->armor = $armor;
        $this->damage = $damage;
        $this->speed = $speed;
        $this->range = $range;
    }

    // Method to attack another ship
    public function attack(Ship $targetShip): void {
        $damageDealt = max(0, $this->damage - $targetShip->armor);
        $targetShip->lifePoints -= $damageDealt;
        echo "{$this->name} attacks {$targetShip->name} and deals {$damageDealt} damage.\n";
    }

    // Method to check if the ship is destroyed
    public function isDestroyed(): bool {
        return $this->lifePoints <= 0;
    }
}

?>
