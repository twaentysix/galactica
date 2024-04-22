<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Expeditions extends Model
{
    protected $table = 'expeditions';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'started_at',
        'ended_at',
        'duration',
        'metal',
        'gas',
        'gems',
        'fleet_id'
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
            'status' => 'string',
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'duration' => 'integer',
            'metal' => 'float',
            'gas' => 'float',
            'gems' => 'float',
        ];
    }

    /**
     * @return HasOne
     */
    public function battle(): HasOne
    {
        return $this->hasOne(Battles::class, 'expedition_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function fleet(): BelongsTo
    {
        return $this->belongsTo(Fleets::class, 'fleet_id', 'id');
    }
}
