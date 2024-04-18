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
            'type' => $this->type,
            'lastCollected' => $this->last_collected,
            'level' => $this->level,
            'upgradePrice' => $this->upgradePrice(),
            'amountStored' => $this->getAmountStored(),
        ];
    }
}
