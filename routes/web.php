<?php

use App\Http\Controllers\ProfileController;
use App\Models\Appointment;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
})->name('home');

// Agendamento público da loja única (sem {business})
Route::get('/agendar', fn () => view('booking'))->name('booking.show');
Route::get('/booking/{business}', fn () => redirect()->route('booking.show'));

Route::match(['GET', 'POST'], '/login-demo', function (Request $r) {
    $biz = Business::first() ?? Business::create(['name' => config('app.name', 'PetCare'), 'slug' => 'loja', 'email' => 'contato@petcare.test']);
    $user = User::where('email', 'demo@petcare.test')->first();
    if (! $user) {
        $user = User::create(['name' => 'Demo', 'email' => 'demo@petcare.test', 'password' => 'password', 'current_business_id' => $biz->id, 'email_verified_at' => now()]);
        try {
            $user->businesses()->attach($biz->id, ['role' => 'owner']);
        } catch (Throwable $e) {
        }
    } elseif (! $user->current_business_id) {
        $user->update(['current_business_id' => $biz->id]);
    }
    Auth::login($user, true);
    $r->session()->regenerate();

    return redirect()->route('dashboard');
})->middleware('guest')->name('login.demo');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => view('pages.dashboard', ['title' => 'Dashboard', 'subtitle' => 'Visão geral da operação']))->name('dashboard');

    // Compat: rotas antigas do SaaS redirecionam para o dashboard
    Route::get('/business/select', fn () => redirect()->route('dashboard'))->name('business.select');
    Route::post('/business/switch/{id}', fn () => redirect()->route('dashboard'))->name('business.switch');
    Route::get('/portal', fn () => redirect()->route('dashboard'))->name('portal.index');

    $r = fn ($uri, $view, $name, $title) => Route::get($uri, fn () => view($view, ['title' => $title]))->name($name);
    $r('/customers', 'customers.index', 'customers.index', 'Clientes');
    $r('/customers/create', 'customers.create', 'customers.create', 'Novo cliente');
    Route::get('/customers/{customer}', fn (Customer $c) => view('customers.show', compact('c') + ['title' => $c->name]))->name('customers.show');
    $r('/pets', 'pets.index', 'pets.index', 'Pets');
    $r('/pets/create', 'pets.create', 'pets.create', 'Novo pet');
    Route::get('/pets/{pet}', fn (Pet $p) => view('pets.show', compact('p') + ['title' => $p->name]))->name('pets.show');
    $r('/appointments', 'appointments.index', 'appointments.index', 'Agendamentos');
    $r('/appointments/create', 'appointments.create', 'appointments.create', 'Novo agendamento');
    Route::get('/appointments/{appointment}', fn (Appointment $a) => view('appointments.show', compact('a') + ['title' => 'Agendamento']))->name('appointments.show');
    $r('/calendar', 'calendar.index', 'calendar.index', 'Agenda');
    $r('/kanban', 'kanban.index', 'kanban.index', 'Quadro de atendimento');
    $r('/checkin', 'checkin.index', 'checkin.index', 'Check-in');
    $r('/checkout', 'checkout.index', 'checkout.index', 'Check-out');
    $r('/grooming', 'grooming.index', 'grooming.index', 'Banho & Tosa');
    $r('/daycare', 'daycare.index', 'daycare.index', 'Creche');
    $r('/boarding', 'boarding.index', 'boarding.index', 'Hospedagem');
    $r('/services', 'services.index', 'services.index', 'Serviços');
    $r('/professionals', 'professionals.index', 'professionals.index', 'Equipe');
    $r('/commissions', 'commissions.index', 'commissions.index', 'Comissões');
    $r('/packages', 'packages.index', 'packages.index', 'Pacotes e planos');
    $r('/loyalty', 'loyalty.index', 'loyalty.index', 'Fidelidade');
    $r('/products', 'products.index', 'products.index', 'Produtos');
    $r('/inventory', 'inventory.index', 'inventory.index', 'Estoque');
    $r('/suppliers', 'suppliers.index', 'suppliers.index', 'Fornecedores');
    $r('/purchases', 'purchases.index', 'purchases.index', 'Compras');
    $r('/sales', 'pos.index', 'pos.index', 'PDV');
    $r('/payments', 'payments.index', 'payments.index', 'Pagamentos');
    $r('/cash', 'cash.index', 'cash.index', 'Caixa');
    $r('/financial', 'financial.index', 'financial.index', 'Financeiro');
    $r('/leads', 'leads.index', 'leads.index', 'CRM · Leads');
    $r('/reports', 'reports.index', 'reports.index', 'Relatórios');
    $r('/settings', 'settings.index', 'settings.index', 'Configurações');
    // Auditoria antiga: mantém compatibilidade mas aponta para relatórios
    Route::get('/activity', fn () => redirect()->route('reports.index'))->name('activity.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
