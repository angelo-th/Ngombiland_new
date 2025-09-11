<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        SupportMessage::create([
            'email' => $data['email'],
            'message' => $data['message'],
            'user_id' => auth()->id(),
        ]);

        return response()->json(['success' => 'Message sent successfully!']);
    }
}
