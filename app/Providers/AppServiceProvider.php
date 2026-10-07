<?php

namespace App\Providers;

use App\Events\AppointmentCreated;
use App\Events\AppointmentStatusChanged;
use App\Listeners\LogStatusChange;
use App\Listeners\SendAppointmentNotification;
use App\Models\Appointment;
use App\Models\Business;
use App\Models\User;
use App\Observers\AppointmentObserver;
use App\Services\PaymentGatewayInterface;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentGatewayInterface::class, fn () => new class implements PaymentGatewayInterface
        {
            public function charge(float $a, array $m = []): array
            {
                return ['ok' => true, 'ref' => 'stub'];
            }

            public function refund(string $r): bool
            {
                return true;
            }
        });
    }

    public function boot(): void
    {
        Appointment::observe(AppointmentObserver::class);
        Gate::define('access-module', fn ($u, $m) => true);
        Event::listen(AppointmentCreated::class, SendAppointmentNotification::class);
        Event::listen(AppointmentStatusChanged::class, LogStatusChange::class);
        // Garante empresa única + vínculo do usuário (migração transparente SaaS -> single)
        User::retrieved(function ($u) {
            if (! $u->current_business_id) {
                try {
                    $biz = Business::first() ?? Business::create(['name' => config('app.name', 'PetCare'), 'slug' => 'loja', 'email' => 'contato@petcare.test']);
                    $u->forceFill(['current_business_id' => $biz->id])->saveQuietly();
                    try {
                        $u->businesses()->syncWithoutDetaching([$biz->id => ['role' => 'owner']]);
                    } catch (\Throwable $e) {
                    }
                } catch (\Throwable $e) {
                }
            }
        });
    }
}
