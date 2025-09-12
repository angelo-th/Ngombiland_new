<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        // Vérifier que l'utilisateur peut voir ce message
        if ($message->sender_id !== auth()->id() && $message->receiver_id !== auth()->id()) {
            abort(403, 'Non autorisé');
        }

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
            'message' => 'required|string|max:1000',
        ]);

        // Vérifier que l'utilisateur ne s'envoie pas un message à lui-même
        if ($request->receiver_id == auth()->id()) {
            return back()->withErrors(['receiver_id' => 'Vous ne pouvez pas vous envoyer un message à vous-même.']);
        }

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        // Envoyer une notification au destinataire
        $sender = auth()->user();
        NotificationService::sendMessageNotification(
            $request->receiver_id,
            $sender->name,
            Str::limit($request->message, 50)
        );

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
