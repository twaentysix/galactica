<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Battles extends Model
{
    use HasFactory;

    protected $table = 'battles';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'opponent_id',
        'fleet_id',
        'won',
        'lost_ships',
        'base_id',
        'finished',
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
            'opponent_id' => 'integer',
            'fleet_id' => 'integer',
            'won' => 'boolean',
            'lost_ships' => 'integer',
            'base_id' => 'integer',
            'finished' => 'boolean'
        ];
    }

    /**
     * @return belongsTo
     */
    public function fleet(): BelongsTo
    {
        return $this->belongsTo(Fleets::class, 'fleet_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function opponent(): BelongsTo
    {
        return $this->belongsTo(Fleets::class, 'opponent_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function base(): BelongsTo
    {
        return $this->belongsTo(Fleets::class, 'base_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function expedition(): BelongsTo
    {
        return $this->belongsTo(Expeditions::class, 'expedition_id', 'id');
    }

}
