<?php

namespace App\Http\Resources;

use App\Models\Bases;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanetsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $base = $this->base;
        return [
            'id' => $this->id,
            'occupied' => (bool)$base,
            'occupiedBy' => $base ? new UserResource($base->user) : null,
            'name' => $this->name,
        ];
    }
}
