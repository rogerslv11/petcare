<?php

namespace App\Services;

class WhatsAppService implements NotificationChannelInterface
{
    public function send(string $to, string $message): bool
    {
        \Log::info("[WhatsApp] to=$to msg=$message");

        return true;
    }
}
