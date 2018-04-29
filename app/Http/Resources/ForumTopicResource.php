<?php

namespace App\Http\Resources;

use App\Forum;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ForumTopicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'forum' => new ForumResource($this->whenLoaded('forum')),
            'user' => new UserResource($this->whenLoaded('user')),
            'name' => $this->name,
            'slug' => $this->slug,
            'locked' => $this->locked,
            'pinned' => $this->pinned,
            'views' => $this->views,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans()
        ];
    }
}
