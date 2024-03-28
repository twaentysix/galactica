<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resources extends Model
{
    use HasFactory;

    protected $table = 'base_resources';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'base_id',
        'metal',
        'cristal',
        'gas'
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
            'metal' => 'integer',
            'gas' => 'integer',
            'cristal' => 'integer',
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
