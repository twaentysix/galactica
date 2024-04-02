<?php

namespace App\Http\Resources;

use App\Http\Controllers\CollectorsController;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BasesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $army = $this->army;
        $resources = $this->resources;
        $collectors = $this->collectors;
        $user = $this->user;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'level' => $this->level,
            'createdAt' => $this->created_at,
            'lastUpgraded' => $this->last_upgraded_at,
            'army' => $army ? new ArmyResource($army) : null,
            'resources' => $resources ? new ResourcesResource($resources) : null,
            'collectors' => $collectors ? new CollectorsCollection($collectors) : null,
            'user' => $user ? new UserResource($user) : null,
        ];
    }
}
