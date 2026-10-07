<?php

namespace Tests\Feature;

use App\Actions\CompleteCheckoutAction;
use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\PetSpecies;
use App\Models\Product;
use App\Models\Professional;
use App\Models\Service;
use App\Models\User;
use App\Services\AppointmentService;
use App\Services\SaleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetCareTest extends TestCase
{
    use RefreshDatabase;

    protected function biz(): Business
    {
        $b = Business::create(['name' => 'T', 'slug' => 't-'.rand(1, 99999)]);
        Branch::create(['business_id' => $b->id, 'name' => 'U', 'code' => 'U'.rand(1, 99999)]);

        return $b;
    }

    protected function user(?Business $b = null): User
    {
        $b = $b ?? $this->biz();
        $u = User::factory()->create(['current_business_id' => $b->id]);
        $u->businesses()->attach($b->id, ['role' => 'owner']);

        return $u;
    }

    public function test_tenant_isolation(): void
    {
        $a = $this->biz();
        $b = $this->biz();
        Customer::create(['business_id' => $a->id, 'name' => 'A']);
        Customer::create(['business_id' => $b->id, 'name' => 'B']);
        $u = $this->user($a);
        $this->actingAs($u);
        $this->assertEquals(1, Customer::count());
        $this->assertEquals('A', Customer::first()->name);
    }

    public function test_available_slots_respects_conflict(): void
    {
        $b = $this->biz();
        $u = $this->user($b);
        $this->actingAs($u);
        $sp = PetSpecies::create(['name' => 'Cães']);
        $c = Customer::create(['business_id' => $b->id, 'name' => 'C']);
        $pet = Pet::create(['business_id' => $b->id, 'customer_id' => $c->id, 'name' => 'Rex']);
        $pro = Professional::create(['business_id' => $b->id, 'name' => 'G']);
        $svc = Service::create(['business_id' => $b->id, 'name' => 'Banho', 'duration_min' => 60, 'price' => 50]);
        Appointment::create(['business_id' => $b->id, 'customer_id' => $c->id, 'pet_id' => $pet->id, 'professional_id' => $pro->id, 'service_id' => $svc->id, 'scheduled_at' => today()->setTime(9, 0), 'ends_at' => today()->setTime(10, 0), 'status' => 'confirmed']);
        $slots = app(AppointmentService::class)->availableSlots($pro->id, today()->toDateString(), 60);
        $this->assertNotContains('09:00', $slots);
        $this->assertContains('10:00', $slots);
    }

    public function test_checkout_creates_payment_and_commission(): void
    {
        $b = $this->biz();
        $u = $this->user($b);
        $this->actingAs($u);
        $c = Customer::create(['business_id' => $b->id, 'name' => 'C']);
        $pet = Pet::create(['business_id' => $b->id, 'customer_id' => $c->id, 'name' => 'Rex']);
        $pro = Professional::create(['business_id' => $b->id, 'name' => 'G', 'commission_pct' => 10]);
        $svc = Service::create(['business_id' => $b->id, 'name' => 'Banho', 'price' => 100]);
        $a = Appointment::create(['business_id' => $b->id, 'customer_id' => $c->id, 'pet_id' => $pet->id, 'professional_id' => $pro->id, 'service_id' => $svc->id, 'scheduled_at' => now(), 'price' => 100, 'status' => 'ready']);
        app(CompleteCheckoutAction::class)->execute($a, 'pix');
        $this->assertDatabaseHas('payments', ['appointment_id' => $a->id, 'status' => 'paid']);
        $this->assertDatabaseHas('commissions', ['appointment_id' => $a->id, 'amount' => 10]);
    }

    public function test_pos_checkout_decrements_stock_and_earns_loyalty(): void
    {
        $b = $this->biz();
        $u = $this->user($b);
        $this->actingAs($u);
        $c = Customer::create(['business_id' => $b->id, 'name' => 'C']);
        $p = Product::create(['business_id' => $b->id, 'name' => 'Ração', 'price' => 100, 'stock' => 10]);
        $sale = app(SaleService::class)->checkout(['business_id' => $b->id, 'customer_id' => $c->id, 'items' => [['item_type' => 'product', 'item_id' => $p->id, 'name' => 'Ração', 'qty' => 2, 'unit_price' => 100]], 'method' => 'pix']);
        $this->assertEquals(200, $sale->total);
        $this->assertEquals(8, $p->fresh()->stock);
        $this->assertDatabaseHas('loyalty_accounts', ['customer_id' => $c->id]);
    }
}
