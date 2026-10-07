<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PetReadyNotification extends Notification
{
    use Queueable;

    public function __construct(public string $petName) {}

    public function via($n): array
    {
        return ['database'];
    }

    public function toArray($n): array
    {
        return ['title' => 'Pet pronto! 🐾', 'body' => "{$this->petName} está pronto para retirada.", 'icon' => '🐾'];
    }
}
