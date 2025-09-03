<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::where('receiver_id', auth()->id())
                          ->with('sender')
                          ->latest()
                          ->paginate(20);
        return view('messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        // Marquer le message comme lu
        if ($message->receiver_id === auth()->id()) {
            $message->update(['read' => true]);
        }
        
        return view('messages.show', compact('message'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Message envoyé avec succès');
    }
}
