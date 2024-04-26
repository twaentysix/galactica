<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fleets extends Model
{
    use HasFactory;

    protected $table = 'fleets';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'light_fighter',
        'transporter',
        'heavy_fighter',
        'battleships',
        'cruiser',
        'name',
        'busy',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'harbour_id' => 'integer',
            'broken_ships' => 'integer',
            'light_fighter' => 'integer',
            'transporter' => 'integer',
            'heavy_fighter' => 'integer',
            'battleship' => 'integer',
            'cruiser' => 'integer',
            'name' => 'string',
            'busy' => 'boolean'
        ];
    }

    /**
     * Multiplier to edit expedition Resources
     * @return float
     */
    public function getExpeditionResourceMultiplier () : float
    {
        $multiplier = 1;
        $multiplier += $this->transporter * 0.002;
        $multiplier += $this->heavy_fighter * 0.001;
        $multiplier += $this->cruiser * 0.0015;
        $multiplier += $this->light_fighter * 0.0005;
        $multiplier += $this->battleships * 0.0005;
        return $multiplier;
    }

    /**
     * Get Battle strength of a fleet to determine if it wins a battle.
     * @return float
     */
    public function getBattleStrength () : float
    {
        $strength = 0;
        $strength += $this->transporter * 2;
        $strength += $this->heavy_fighter * 10;
        $strength += $this->cruiser * 12;
        $strength += $this->light_fighter * 7;
        $strength += $this->battleships * 15;
        return $strength;
    }

    /**
     * Different rates for types of ships because different ships are differently involved in battles.
     * @param float $rate
     * @return float
     */
    public function destroyShipsAfterBattle(float $rate): float
    {
        $amountShips = $this->transporter + $this->heavy_fighter + $this->light_fighter + $this->battleships + $this->cruiser;
        $lostShips = $amountShips * $rate;

        // percentage of all ships
        $pHF = $this->heavy_fighter / $amountShips;
        $pLF = $this->heavy_fighter / $amountShips;
        $pC = $this->heavy_fighter / $amountShips;
        $pT = $this->heavy_fighter / $amountShips;
        $pBS = $this->heavy_fighter / $amountShips;

        // subtract standard part of the lostShips considering the percentage
        $newHF = $this->heavy_fighter - $lostShips * $pHF;
        $newLF = $this->light_fighter - $lostShips * $pLF;
        $newC = $this->cruiser - $lostShips * $pC;
        $newT = $this->transporter - $lostShips * $pT;
        $newBS = $this->battleships - $lostShips * $pBS;

        // additionally destroy some ships according to ship specific survival rate
        $newHF = (int)($newHF * (1 - 0.2 * $rate));
        $newLF = (int)($newLF * (1 - 0.3 * $rate));
        $newC = (int)($newC * (1 - 0.15 * $rate));
        $newT = (int)($newT * (1 - 0.1 * $rate));
        $newBS = (int)($newBS * (1 - 0.25 * $rate));

        $this->update([
            'battleships' => $newBS,
            'heavy_fighter' => $newHF,
            'light_fighter' => $newLF,
            'cruiser' => $newC,
            'transporter' => $newT,
        ]);
        $this->save();

        return $lostShips;
    }


    /**
     * @return BelongsTo
     */
    public function harbour(): BelongsTo
    {
        return $this->belongsTo(Harbours::class,'harbour_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function battles(): HasMany
    {
        return $this->hasMany(Battles::class,'fleet_id', 'id');
    }

    public function expeditions(): hasMany
    {
        return $this->hasMany(Expeditions::class,'fleet_id', 'id');
    }
}
