<?php

namespace Database\Seeders;

use App\Models\Armies;
use App\Models\Bases;
use App\Models\Galaxies;
use App\Models\Planets;
use App\Models\ResourceCollectors;
use App\Models\Resources;
use App\Models\Troops;
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

        $army = Armies::create([
            'ships' => 0,
            'broken_ships' => 0,
        ]);
        $army->base()->associate($base);
        $army->save();

        $troop = Troops::create([
            'broken_ships' => 0,
            'ships' => 0,
            'name' => 'Affenbande',
        ]);
        $troop->army()->associate($army);
        $troop->save();

        $resources = Resources::create([
            'metal' => 0,
            'gas' => 0,
            'cristal' => 0,
        ]);
        $resources->base()->associate($base);
        $resources->save();

        $metal_collector = ResourceCollectors::create([
            'type' => 'metal',
            'last_collected' => Carbon::now(),
            'level' => 1,
            'rate_per_hour' => 2
        ]);
        $metal_collector->base()->associate($base);
        $metal_collector->save();

        $gas_collector = ResourceCollectors::create([
            'type' => 'gas',
            'last_collected' => Carbon::now(),
            'level' => 1,
            'rate_per_hour' => 2
        ]);
        $gas_collector->base()->associate($base);
        $gas_collector->save();

        $cristal_collector = ResourceCollectors::create([
            'type' => 'cristal',
            'last_collected' => Carbon::now(),
            'level' => 1,
            'rate_per_hour' => 2
        ]);
        $cristal_collector->base()->associate($base);
        $cristal_collector->save();



    }
}
