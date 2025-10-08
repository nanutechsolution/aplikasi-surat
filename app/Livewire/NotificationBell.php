<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationBell extends Component
{
    public $unreadNotifications;
    public $unreadCount;

    // Listener untuk me-refresh notifikasi dari komponen lain
    protected $listeners = ['notifikasiTerkirim' => 'loadNotifications'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->unreadNotifications = auth()->user()->unreadNotifications;
        $this->unreadCount = $this->unreadNotifications->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
        $this->loadNotifications(); // Refresh daftar notifikasi setelah ditandai
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
