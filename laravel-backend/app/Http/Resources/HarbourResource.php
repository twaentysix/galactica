<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HarbourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $fleets = $this->fleets;
        $totalAmountShips = $this->light_fighter + $this->transporter + $this->heavy_fighter + $this->battleships + $this->cruiser;
        return [
            'id' => $this->id,
            'lightFighter' => $this->light_fighter,
            'transporter' => $this->transporter,
            'heavyFighter' => $this->heavy_fighter,
            'battleships' => $this->battleships,
            'cruiser' => $this->cruiser,
            'fleets' => $fleets ? new FleetsCollection($fleets) : null,
            'totalAmountShips' => $totalAmountShips
        ];
    }
}
