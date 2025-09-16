<?php

namespace App\Livewire;

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
        $this->notifications = Auth::user()
            ->unreadNotifications()
            ->take(5) // limit dropdown items
            ->get();
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
