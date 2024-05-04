<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LaravelIdea\Helper\App\Models\_IH_Expeditions_C;

class Harbours extends Model
{
    use HasFactory;

    protected $table = 'harbours';
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
        'fleet_cap',
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
            'fleet_cap' => 'integer',
        ];
    }

    /**
     * Get amount of ships, not added to fleets yet.
     * @return array
     */
    public function getIdleShips (): array
    {
        $lf = $this->light_fighter;
        $hf = $this->heavy_fighter;
        $c = $this->cruiser;
        $t = $this->transporter;
        $b = $this->battleships;

        foreach ($this->fleets as $fleet){
            $lf -= $fleet->light_fighter;
            $hf -= $fleet->heavy_fighter;
            $c -= $fleet->cruiser;
            $t -= $fleet->transporter;
            $b -= $fleet->battleships;
        }
        return [
            'light_fighter' => $lf,
            'heavy_fighter' => $hf,
            'cruiser' => $c,
            'battleships' => $b,
            'transporter' => $t,
        ];
    }

    /**
     * @return Expeditions[]|Builder[]|Collection|_IH_Expeditions_C|null
     */
    public function getUnseenExpeditions(): Collection|array|_IH_Expeditions_C|null
    {
        $expeditions = Expeditions::where('notified', '=', false)
                            ->whereNotNull('ended_at')
                            ->whereRelation('fleet', 'harbour_id', '=', $this->id)
                            ->get();
        if(sizeof($expeditions) === 0){
            return null;
        }else{
            return $expeditions;
        }
    }

    /**x
     * @return BelongsTo
     */
    public function base()
    {
        return $this->belongsTo(Bases::class,'base_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function fleets()
    {
        return $this->hasMany(Fleets::class,'harbour_id', 'id');
    }
}
