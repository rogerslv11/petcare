<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VaccineDueNotification extends Notification
{
    use Queueable;

    public function __construct(public string $pet, public string $vaccine) {}

    public function via($n): array
    {
        return ['database'];
    }

    public function toArray($n): array
    {
        return ['title' => 'Vacina próxima 💉', 'body' => "$this->pet: $this->vaccine vence em breve."];
    }
}
