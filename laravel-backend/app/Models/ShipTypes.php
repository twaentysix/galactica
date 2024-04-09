<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipTypes extends Model
{
    use HasFactory;
    protected $table = 'ship_types';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'health',
        'armor',
        'damage',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'health' => 'integer',
            'armor' => 'integer',
            'damage' => 'integer',
            'type' => 'string'
        ];
    }

    /**
     * @return BelongsTo
     */
    public function harbour()
    {
        return $this->belongsTo(Harbours::class,'harbour_id', 'id');
    }
}
