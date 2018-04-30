<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /*$table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('chatroom_id')->unsigned();
            $table->text('message');
            $table->timestamps();
        */
        return [
            'id' => $this->id,
        ];
    }
}
