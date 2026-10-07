<?php

namespace App\Services;

interface PaymentGatewayInterface
{
    public function charge(float $amount, array $meta = []): array;

    public function refund(string $ref): bool;
}
