<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

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
            'receiver_id' => 'required|exists:users,id|different:'.auth()->id(),
            'message' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return redirect('/messages')->with('success', 'Message envoyé avec succès');
    }

    public function destroy(Message $message)
    {
        // Vérifier que l'utilisateur peut supprimer ce message
        if ($message->receiver_id !== auth()->id() && $message->sender_id !== auth()->id()) {
            abort(403, 'Non autorisé');
        }

        $message->delete();

        return redirect('/messages')->with('success', 'Message supprimé avec succès');
    }
}
