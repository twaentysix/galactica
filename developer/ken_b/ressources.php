<?php

class Ressources {
    public float $metal;
    public float $crystal;
    public float $fuel;

    public function __construct()
    {
        $this->metal = 0;
        $this->crystal = 0;
        $this->fuel = 0;
    }

    public function generateRessources(int $playerLevel, float $timeInterval = 10.0): void
    {
        // Annahme: Jeder Spielerlevel erhöht den Multiplikator um 0.1
        $multiplier = 1.0 + ($playerLevel * 0.1);

        $generationRate = 1.0; // Beispielrate, wie viel jede Ressource pro Sekunde generiert wird

        //Generiert Ressourcen basierend auf Zeitintervall und Multiplier
        $metalGenerated = $generationRate * $multiplier * ($timeInterval / 10.0);
        $crystalGenerated = $generationRate * $multiplier * ($timeInterval / 10.0);
        $fuelGenerated = $generationRate * $multiplier * ($timeInterval / 10.0);

        // Füge die generierten Ressourcen hinzu
        $this->metal += $metalGenerated;
        $this->crystal += $crystalGenerated;
        $this->fuel += $fuelGenerated;
    }
}

$playerLevel = 5; // Beispiel-Level des Spielers
(new Ressources)->generateRessources($playerLevel);
