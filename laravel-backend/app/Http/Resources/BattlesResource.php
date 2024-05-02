<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BattlesResource extends JsonResource
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
            'won' => $this->won,
            'fleet' => new FleetsResource($this->fleet),
            'lostShips' => $this->lost_ships,
            'opponent' => $this->opponent->name,
        ];
    }
}
