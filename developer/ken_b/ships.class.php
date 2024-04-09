<?php

// Define a class for ships
class ShipDefinition {
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
}

?>
