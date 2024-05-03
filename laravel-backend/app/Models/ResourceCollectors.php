<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResourceCollectors extends Model
{

    static int $BASIS_COST_GEMS = 50;
    static int $BASIS_COST_METAL = 180;
    static int $BASIS_COST_GAS = 130;

    static int $BASIS_PROD_GEMS = 60;
    static int $BASIS_PROD_METAL = 190;
    static int $BASIS_PROD_GAS = 140;

    static float $UPGRADE_PARAM_GEMS = 1.05;
    static float $UPGRADE_PARAM_METAL = 1.12;
    static float $UPGRADE_PARAM_GAS = 1.09;

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
        'max_capacity',
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
            'max_capacity' => 'integer',
        ];
    }

    /**
     * @return BelongsTo
     */
    public function base(): BelongsTo
    {
        return $this->belongsTo(Bases::class,'base_id', 'id');
    }

    public function collect(): void
    {
        $amount = $this->getAmountStored();
        $resources = $this->base->resources;
        switch($this->type){
            case 'metal':
                $resources->update([
                    'metal' => $resources->metal += $amount,
                ]);
                break;
            case 'gems':
                $resources->update([
                    'gems' => $resources->gems += $amount,
                ]);
                break;
            case 'gas':
                $resources->update([
                    'gas' => $resources->gas += $amount,
                ]);
                break;
        }
        $resources->save();
        if($amount > 0) {
            $this->update([
                'last_collected' => Carbon::now(),
            ]);
        }
        $this->save();
    }

    public function getAmountStored () {
        $hoursSinceLastCollected = round($this->last_collected->diffInHours(Carbon::now()),2);
        $amount = match ($this->type) {
            'metal' => self::$BASIS_PROD_METAL * (pow(self::$UPGRADE_PARAM_METAL, $this->level)),
            'gas' => self::$BASIS_PROD_GAS * (pow(self::$UPGRADE_PARAM_GAS, $this->level)),
            'gems' => self::$BASIS_PROD_GEMS * (pow(self::$UPGRADE_PARAM_GEMS, $this->level)),
        };
        $amount = $amount * $hoursSinceLastCollected;
        return $amount > $this->max_capacity ? $this->max_capacity : round($amount, 2);
    }

    public function upgrade (): array | bool
    {
        $resources = $this->base->resources;
        $metal = $resources->metal;
        $gems = $resources->gems;
        $gas = $resources->gas;
        $price = $this->upgradePrice();

        if($metal >= $price['metal'] && $gems >= $price['gems'] && $gas >= $price['gas']){
            $level = $this->level + 1;
            $this->update([
                'level' => $level,
            ]);
            $this->save();
            $resources->update([
                'metal' => $metal - $price['metal'],
                'gems' => $metal - $price['gems'],
                'gas' => $metal - $price['gas']
            ]);
            $resources->save();
            return true;
        }
        return false;
    }

    public function upgradePrice(): array
    {
        return [
            'metal' => round(self::$BASIS_COST_METAL * (pow(self::$UPGRADE_PARAM_METAL, $this->level)),2),
            'gas' => round(self::$BASIS_COST_GAS * (pow(self::$UPGRADE_PARAM_GAS, $this->level)),2),
            'gems' => round(self::$BASIS_COST_GEMS * (pow(self::$UPGRADE_PARAM_GEMS, $this->level)), 2),
        ];

    }
}
