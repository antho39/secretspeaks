<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;
use Vinkla\Pusher\Facades\Pusher as LaravelPusher;

class ChatController extends Controller
{
    public function getUserConversationById(Request $request) {
        $userId = $request->input('id');
        $authUserId = $request->user()->id;
        $chats = Chat::whereIn('sender_id', [$authUserId, $userId])
            ->whereIn('receiver_id', [$authUserId, $userId])
            ->orderBy('created_at', 'asc')
            ->get();

        return response(['data'=> $chats], 200);
    }

    public function saveUserChat(Request $request) {
        $data = $request->all();
        $data['sender_id'] = $request->user()->id;
        $chat = Chat::create($data);
        $finalData = Chat::where('id', $chat->id)->first();
        LaravelPusher::trigger('chat_channel', 'chat_saved', ['message' => $finalData]);

        return response(['data' => $chat], 201);
    }
}
