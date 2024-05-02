<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 *
 */
class Planets extends Model
{
    protected $table = 'planets';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'galaxy_id'
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
            'name' => 'string',
            'id' => 'integer',
            'galaxy_id' => 'integer'
        ];
    }

    /**
     * @return BelongsTo
     */
    public function galaxy()
    {
        return $this->belongsTo(Galaxies::class, 'galaxy_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function base()
    {
        return $this->hasOne(Bases::class,'planet_id', 'id');
    }
}
