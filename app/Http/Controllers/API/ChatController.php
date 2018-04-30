<?php

namespace App\Http\Controllers\API;

use App\Chatroom;
use App\Http\Resources\ChatMessageResource;
use App\Http\Resources\ChatRoomResource;
use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{

    /* MAIN CHAT ENDPOINT */
    public function chat($id)
    {
        return new ChatRoomResource(Chatroom::with(['users', 'messages'])->find($id));
    }

    /* ROOMS */
    public function rooms()
    {
        return ChatRoomResource::collection(Chatroom::all()->pluck('name'));
    }

    public function createRoom(Request $request)
    {
        $room = Chatroom::where('name', $request->get('name'))->first();

        if ($room !== null) {
            return response(['message' => 'The channel already exists!'], 409);
        }

        return new ChatRoomResource(Chatroom::create([
            'name' => $request->get('name')
        ]));
    }

    public function updateRoom(Request $request, $id)
    {
        $room = Chatroom::findOrFail($id);

        $room->update([
            'name' => $request->get('name')
        ]);

        return new ChatRoomResource($room);
    }

    public function destroyRoom($id)
    {
        $room = Chatroom::findOrFail($id);

        $room->delete();

        return response(['success' => 'Successfully removed chat room!'], 200);
    }

    /* MESSAGES */
    public function messages()
    {
        return ChatMessageResource::collection(Message::all());
    }

    public function createMessage(Request $request)
    {
        return new ChatMessageResource(Message::create([
            'message' => $request->get('message')
        ]));
    }

    public function updateMessage(Request $request, $id)
    {
        $message = Message::findOrFail($id);

        $message->update([
            'message' => $request->get('message')
        ]);

        return new ChatMessageResource($message);
    }

    public function destroyMessage($id)
    {
        $message = Message::findOrFail($id);

        $message->delete();

        return response(['success' => 'Successfully removed chat room!'], 200);
    }
}
