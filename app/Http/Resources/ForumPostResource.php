<?php

namespace App\Http\Resources;

use App\Helpers\Bbcode;
use Illuminate\Http\Resources\Json\JsonResource;

class ForumPostResource extends JsonResource
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
            'topic' => new ForumTopicResource($this->whenLoaded('topic')),
            'user' => new UserResource($this->whenLoaded('user')),
            'body' => $request->has('strip') ? Bbcode::stripBBCode(str_limit($this->body, 50)) : $this->body,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans()
        ];
    }
}
