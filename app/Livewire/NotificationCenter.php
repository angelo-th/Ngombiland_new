<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification;

class NotificationCenter extends Component
{
    public $notifications = [];
    public $unreadCount = 0;
    public $showDropdown = false;
    public $filter = 'all'; // all, unread, read

    protected $listeners = ['notificationReceived' => 'refreshNotifications'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $query = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(10);

        if ($this->filter === 'unread') {
            $query->where('read', false);
        } elseif ($this->filter === 'read') {
            $query->where('read', true);
        }

        $this->notifications = $query->get();
        $this->unreadCount = Notification::where('user_id', auth()->id())
            ->where('read', false)
            ->count();
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
        
        if ($this->showDropdown) {
            $this->loadNotifications();
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::where('id', $notificationId)
            ->where('user_id', auth()->id())
            ->first();

        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('read', false)
            ->update([
                'read' => true,
                'read_at' => now(),
            ]);

        $this->loadNotifications();
    }

    public function deleteNotification($notificationId)
    {
        Notification::where('id', $notificationId)
            ->where('user_id', auth()->id())
            ->delete();

        $this->loadNotifications();
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->loadNotifications();
    }

    public function refreshNotifications()
    {
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-center');
    }
}