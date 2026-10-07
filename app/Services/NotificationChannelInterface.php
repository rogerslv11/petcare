<?php

namespace App\Services;

interface NotificationChannelInterface
{
    public function send(string $to, string $message): bool;
}
