<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArmyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $troops = $this->troops;
        return [
            'id' => $this->id,
            'lightFighter' => $this->light_fighter,
            'transporter' => $this->transporter,
            'heavyFighter' => $this->heavy_fighter,
            'battleships' => $this->battleships,
            'cruiser' => $this->cruiser,
            'troops' => $troops ? new TroopsCollection($troops) : null
        ];
    }
}
