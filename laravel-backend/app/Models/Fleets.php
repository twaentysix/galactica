<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
