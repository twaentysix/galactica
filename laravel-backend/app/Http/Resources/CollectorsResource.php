<?php

namespace App\Http\Resources;

use App\Models\ResourceCollectors;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'lastCollected' => $this->last_collected,
            'level' => $this->level,
            'upgradeCost' => $this->upgradeCost(),
            'amountStored' => $this->getAmountStored(),
        ];
    }
}
