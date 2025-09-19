<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAiProvider;
use App\Http\Controllers\Controller;

class AiController extends Controller
{
    public function chat(Request $request, OpenAiProvider $ai)
    {
        $data = $request->validate([
            'message' => 'required|string|max:4000'
        ]);

        $messages = [
            ['role' => 'system', 'content' => 'You are a helpful assistant.'],
            ['role' => 'user', 'content' => $data['message']],
        ];

        $reply = $ai->chat($messages);

        return response()->json(['reply' => $reply]);
    }
}
