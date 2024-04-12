<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResourceCollectors extends Model
{
    use HasFactory;

    protected $table = 'collectors';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'base_id',
        'type',
        'last_collected',
        'level',
        'rate_per_hour',
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
            'type' => 'string',
            'last_collected' => 'datetime',
            'level' => 'integer',
            'rate_per_hour' => 'integer',
        ];
    }

    /**
     * @return BelongsTo
     */
    public function base()
    {
        return $this->belongsTo(Bases::class,'base_id', 'id');
    }
}
