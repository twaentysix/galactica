<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpeditionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $time_left = $this->started_at ? round($this->duration - $this->started_at->diffInMinutes(Carbon::now(), 2)) : $this->duration;
        return [
            'id' => $this->id,
            'status' => $this->status,
            'duration' => $this->duration,
            'timeLeft' => $time_left,
            'gas' => $this->gas,
            'metal' => $this->metal,
            'gems' => $this->gems,
            'battle' => new BattlesResource($this->battle),
            'fleet' => (new FleetsResource($this->fleet))
        ];
    }

    /**
     * @return array
     */
    public function withoutFleet(): array
    {
        $time_left = $this->started_at ? round($this->duration - $this->started_at->diffInMinutes(Carbon::now(), 2)) : $this->duration;
        return [
            'id' => $this->id,
            'status' => $this->status,
            'duration' => $this->duration,
            'timeLeft' => $time_left,
            'gas' => $this->gas,
            'metal' => $this->metal,
            'gems' => $this->gems,
            'battle' => new BattlesResource($this->battle),
        ];
    }
}
