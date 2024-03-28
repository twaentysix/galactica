<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bases extends Model
{
    use HasFactory;

    protected $table = 'bases';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'level',
        'created_at',
        'last_upgraded_at',
        'planet_id',
        'user_id'
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
            'level' => 'integer',
            'created_at' => 'datetime',
            'last_upgraded_at' => 'datetime'
        ];
    }

    /**
     * @return HasOne
     */
    public function army(){
        return $this->hasOne(Armies::class, 'base_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function resources(){
        return $this->hasOne(Resources::class, 'base_id', 'id');
    }

    /**
     * @return hasMany
     */
    public function collectors(){
        return $this->hasMany(ResourceCollectors::class, 'base_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function planet()
    {
        return $this->belongsTo(Planets::class, 'planet_id', 'id');
    }
}
