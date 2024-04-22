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
        'battleship',
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
