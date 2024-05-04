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
        $harbour = $this->harbour;
        $resources = $this->resources;
        $collectors = $this->collectors;
        $user = $this->user;
        $planet = $this->planet;
        $unseenExpeditions = $this->harbour->getUnseenExpeditions();

        if($unseenExpeditions != null) {
            foreach ($unseenExpeditions as $ex) {
                $ex->update([
                    'notified' => true,
                ]);
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'level' => $this->level,
            'createdAt' => $this->created_at,
            'lastUpgraded' => $this->last_upgraded_at,
            'harbour' => $harbour ? new HarbourResource($harbour) : null,
            'resources' => $resources ? new ResourcesResource($resources) : null,
            'collectors' => $collectors ? new CollectorsCollection($collectors) : null,
            'user' => $user ? new UserResource($user) : null,
            'planet' => $planet ? new PlanetsResource($this->planet) : null,
            'unseenExpeditions' => $unseenExpeditions ? new ExpeditionCollection($unseenExpeditions) : null,
            'upgradeCost' => $this->getUpgradeCost()
        ];
    }

    public function withReward(?String $reward): array
    {
        $harbour = $this->harbour;
        $resources = $this->resources;
        $collectors = $this->collectors;
        $user = $this->user;
        $planet = $this->planet;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'level' => $this->level,
            'createdAt' => $this->created_at,
            'lastUpgraded' => $this->last_upgraded_at,
            'harbour' => $harbour ? new HarbourResource($harbour) : null,
            'resources' => $resources ? new ResourcesResource($resources) : null,
            'collectors' => $collectors ? new CollectorsCollection($collectors) : null,
            'user' => $user ? new UserResource($user) : null,
            'planet' => $planet ? new PlanetsResource($this->planet) : null,
            'reward' => $reward,
            'upgradeCost' => $this->getUpgradeCost()
            ];
    }
}
