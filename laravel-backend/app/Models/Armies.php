<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Armies extends Model
{
    use HasFactory;

    protected $table = 'armies';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'base_id',
        'light_fighter',
        'transporter',
        'heavy_fighter',
        'battleships',
        'cruiser',
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
            'light_fighter' => 'integer',
            'transporter' => 'integer',
            'heavy_fighter' => 'integer',
            'battleships' => 'integer',
            'cruiser' => 'integer',
        ];
    }

    /**
     * @return BelongsTo
     */
    public function base()
    {
        return $this->belongsTo(Bases::class,'base_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function troops()
    {
        return $this->hasMany(Troops::class,'army_id', 'id');
    }
}
