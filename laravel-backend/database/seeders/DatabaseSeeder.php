<?php

namespace Database\Seeders;

use App\Models\Harbours;
use App\Models\Bases;
use App\Models\Galaxies;
use App\Models\Planets;
use App\Models\ResourceCollectors;
use App\Models\Resources;
use App\Models\ShipTypes;
use App\Models\Fleets;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Joriex',
            'email' => 'contact@joriex.de',
            'password' => 'password',
            'email_verified_at' => Carbon::now(),
        ]);
        $user->save();

        $galaxy = Galaxies::create([
            'name' => 'Milchstraße',
        ]);
        $galaxy->save();

        $planet = Planets::create([
            'name' => 'Erde',
        ]);
        $planet->galaxy()->associate($galaxy);
        $planet->save();

        $base = Bases::create([
            'name' => 'StupidBase',
            'created_at' => Carbon::now(),
            'last_upgraded_at' => Carbon::now(),
        ]);
        $base->user()->associate($user);
        $base->planet()->associate($planet);
        $base->save();

        $harbour = Harbours::create([
        ]);
        $harbour->base()->associate($base);
        $harbour->save();

        $fleet = Fleets::create([
            'name' => 'Affenbande',
        ]);
        $fleet->harbour()->associate($harbour);
        $fleet->save();

        $resources = Resources::create([
            'metal' => 0,
            'gas' => 0,
            'gems' => 0,
        ]);
        $resources->base()->associate($base);
        $resources->save();

        $metal_collector = ResourceCollectors::create([
            'type' => 'metal',
            'last_collected' => Carbon::now(),
            'level' => 1,
            'max_capacity' => 5000
        ]);
        $metal_collector->base()->associate($base);
        $metal_collector->save();

        $gas_collector = ResourceCollectors::create([
            'type' => 'gas',
            'last_collected' => Carbon::now(),
            'level' => 1,
            'max_capacity' => 5000
        ]);
        $gas_collector->base()->associate($base);
        $gas_collector->save();

        $gem_collector = ResourceCollectors::create([
            'type' => 'gems',
            'last_collected' => Carbon::now(),
            'level' => 1,
            'max_capacity' => 5000
        ]);
        $gem_collector->base()->associate($base);
        $gem_collector->save();

        ShipTypes::create([
            'type' => 'light_fighter'
        ]);
        ShipTypes::create([
            'type' => 'heavy_fighter'
        ]);
        ShipTypes::create([
            'type' => 'transporter'
        ]);
        ShipTypes::create([
            'type' => 'battleship'
        ]);
        ShipTypes::create([
            'type' => 'cruiser'
        ]);

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
            'transporter' => 50,
            'cruiser' => 50,
            'light_fighter' => 150,
            'heavy_fighter' => 100,
            'battleships' => 50,
            'busy' => false,
        ]);
        $fleet->save();

        $fleet = Fleets::create([
            'name' => 'Pirates_hard',
            'transporter' => 50,
            'cruiser' => 50,
            'light_fighter' => 150,
            'heavy_fighter' => 100,
            'battleships' => 50,
            'busy' => false,
        ]);
        $fleet->save();
    }
}
