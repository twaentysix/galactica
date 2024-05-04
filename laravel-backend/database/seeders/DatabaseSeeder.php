<?php

namespace Database\Seeders;

use App\Models\Fleets;
use App\Models\Galaxies;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $galaxy = Galaxies::create([
            'name' => 'Milky Way',
        ]);
        $galaxy->save();

        $galaxy = Galaxies::create([
            'name' => 'Andromeda',
        ]);
        $galaxy->save();

        $galaxy = Galaxies::create([
            'name' => 'Whirlpool Galaxy',
        ]);
        $galaxy->save();

        $galaxy = Galaxies::create([
            'name' => 'LMC',
        ]);
        $galaxy->save();

        $fleet = Fleets::create([
            'name' => 'Pirates_easy',
            'transporter' => 50,
            'cruiser' => 50,
            'light_fighter' => 150,
            'heavy_fighter' => 100,
            'battleships' => 50,
            'busy' => false,
        ]);
        $fleet->save();
        $fleet = Fleets::create([
            'name' => 'Pirates_medium',
            'transporter' => 70,
            'cruiser' => 235,
            'light_fighter' => 340,
            'heavy_fighter' => 420,
            'battleships' => 400,
            'busy' => false,
        ]);
        $fleet->save();

        $fleet = Fleets::create([
            'name' => 'Pirates_hard',
            'transporter' => 100,
            'cruiser' => 550,
            'light_fighter' => 650,
            'heavy_fighter' => 700,
            'battleships' => 680,
            'busy' => false,
        ]);
        $fleet->save();

    }
}
