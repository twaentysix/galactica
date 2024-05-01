<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bases extends Model
{

    protected $table = 'bases';

    public $timestamps = false;

    private float $BASE_UPGRADE_METAL = 800;
    private float $BASE_UPGRADE_GAS = 600;
    private float $BASE_UPGRADE_GEMS = 400;
    private float $BASE_UPGRADE_FACTOR = 1.13;

    static int $MAX_LEVEL = 15;


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
        'user_id',
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
            'name' => 'string',
            'id' => 'integer',
            'level' => 'integer',
            'created_at' => 'datetime',
            'last_upgraded_at' => 'datetime',
        ];
    }

    /**
     * @return array
     */
    public function getUpgradeCost () :array
    {
        return [
            'metal' => round($this->BASE_UPGRADE_METAL * (pow($this->BASE_UPGRADE_FACTOR, $this->level)),2),
            'gas' => round($this->BASE_UPGRADE_GAS * (pow($this->BASE_UPGRADE_FACTOR, $this->level)),2),
            'gems' => round($this->BASE_UPGRADE_GEMS * (pow($this->BASE_UPGRADE_FACTOR, $this->level)),2)
        ];
    }

    /**
     * @return string
     */
    public function upgrade(): ?string
    {
        $this->update([
            'level' => $this->level + 1,
            'last_upgraded_at' => Carbon::now(),
        ]);
        $this->save();
        switch ($this->level){
            case 2:
            case 7:
            case 12:
                $this->harbour->fleet_cap += 1;
                $this->harbour->save();
                $this->load('harbour');
                return "You unlocked another fleet slot.";
            case 5:
            case 9:
            case 15:
                foreach ($this->collectors as $collector){
                    $collector->max_capacity += 1000;
                    $collector->save();
                }
                $this->load('collectors');
                return "Your collectors Max-Capacity was increased by 1000.";
            default:
                return null;
        }
    }

    /**
     * @return HasOne
     */
    public function harbour(): HasOne
    {
        return $this->hasOne(Harbours::class, 'base_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function resources(): HasOne
    {
        return $this->hasOne(Resources::class, 'base_id', 'id');
    }

    /**
     * @return hasMany
     */
    public function collectors(): HasMany
    {
        return $this->hasMany(ResourceCollectors::class, 'base_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function planet(): BelongsTo
    {
        return $this->belongsTo(Planets::class, 'planet_id', 'id');
    }
}
