<?php

namespace App\Livewire\Notification;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{

    public $notifications;

    protected $listeners = ['notificationAdded' => 'loadNotifications'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Auth::user()->unreadNotifications->sortByDesc('created_at')->take(5);
        $this->unreadCount = Auth::user()->unreadNotifications->count();
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }

        $this->loadNotifications();
        $this->mount();
    }

    public function markAllAsRead()
    {
        $notifications = Auth::user()->unreadNotifications()->get();
        $notifications->markAsRead();

        $this->loadNotifications();
    }


    public function render()
    {
        return view('livewire.notification.notification-bell', [
            'notifications' => $this->notifications,
            'unreadCount' => $this->unreadCount,
        ]);
    }
}