<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationDropdown extends Component
{
    public function render()
    {
        $notes = auth()->user()->notifications()->latest()->limit(8)->get();
        $unread = auth()->user()->unreadNotifications()->count();

        return view('livewire.notification-dropdown', compact('notes', 'unread'));
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }
}
