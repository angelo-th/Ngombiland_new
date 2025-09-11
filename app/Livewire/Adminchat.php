<?php

namespace App\Http\Livewire;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class AdminChat extends Component
{
    public $selectedUserId;

    public $messageText;

    public $users;

    public $messages = [];

    protected $listeners = ['refreshChat' => '$refresh'];

    public function mount()
    {
        $this->users = User::all(); // liste des utilisateurs
        $this->selectedUserId = $this->users->first()->id ?? null;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if ($this->selectedUserId) {
            $this->messages = Message::where(function ($q) {
                $q->where('user_id', $this->selectedUserId)
                    ->orWhere('sender', 'admin');
            })->orderBy('created_at')->get();
        }
    }

    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;
        $this->loadMessages();
    }

    public function sendMessage()
    {
        if (! $this->messageText) {
            return;
        }

        Message::create([
            'user_id' => $this->selectedUserId,
            'sender' => 'admin',
            'text' => $this->messageText,
        ]);

        $this->messageText = '';
        $this->loadMessages();
        $this->emit('refreshChat');
    }

    public function render()
    {
        return view('livewire.admin-chat');
    }
}
