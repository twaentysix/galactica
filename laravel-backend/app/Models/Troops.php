<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Troops extends Model
{
    use HasFactory;

    protected $table = 'troops';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ships',
        'broken_ships',
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
            'army_id' => 'integer',
            'ships' => 'integer',
            'broken_ships' => 'integer',
            'name' => 'string',
        ];
    }

    /**
     * @return BelongsTo
     */
    public function army()
    {
        return $this->belongsTo(Armies::class,'army_id', 'id');
    }
}
