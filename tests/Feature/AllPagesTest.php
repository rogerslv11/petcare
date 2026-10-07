<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AllPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $biz = Business::create(['name' => 'Loja Teste', 'slug' => 'loja', 'email' => 'loja@test.com']);
        $user = User::create(['name' => 'Test', 'email' => 't@t.com', 'password' => 'password', 'current_business_id' => $biz->id, 'email_verified_at' => now()]);
        try {
            $user->businesses()->attach($biz->id, ['role' => 'owner']);
        } catch (\Throwable $e) {
        }
        $this->user = $user;
        $this->biz = $biz;
        $cust = Customer::create(['business_id' => $biz->id, 'name' => 'Cliente Teste', 'phone' => '11999999999', 'status' => 'active']);
        $pet = Pet::create(['business_id' => $biz->id, 'customer_id' => $cust->id, 'name' => 'Rex', 'status' => 'active']);
        $svc = Service::create(['business_id' => $biz->id, 'name' => 'Banho', 'price' => 60, 'duration_min' => 60, 'status' => 'active']);
        $appt = Appointment::create(['business_id' => $biz->id, 'customer_id' => $cust->id, 'pet_id' => $pet->id, 'service_id' => $svc->id, 'type' => 'bath', 'status' => 'confirmed', 'scheduled_at' => now()->addDay(), 'price' => 60]);
        $this->cust = $cust;
        $this->pet = $pet;
        $this->appt = $appt;
    }

    public function test_all_pages(): void
    {
        $dyn = ['{customer}' => $this->cust->id, '{pet}' => $this->pet->id, '{appointment}' => $this->appt->id, '{business}' => 'loja', '{path}' => 'x', '{filename}' => 'x', '{component}' => 'x', '{id}' => '1', '{hash}' => 'x', '{token}' => 'x'];
        $routes = Route::getRoutes();
        $failures = [];
        $checked = 0;
        foreach ($routes as $r) {
            $methods = $r->methods();
            if (! in_array('GET', $methods)) {
                continue;
            }
            $uri = $r->uri();
            if (str_starts_with($uri, 'livewire') || str_starts_with($uri, 'storage') || $uri === 'up' || str_starts_with($uri, 'verify-email/')) {
                continue;
            }
            $mw = implode(',', $r->gatherMiddleware());
            $needsAuth = str_contains($mw, 'Authenticate');
            // resolve params
            $url = '/'.$uri;
            foreach ($dyn as $k => $v) {
                $url = str_replace($k, $v, $url);
            }
            if (str_contains($url, '{')) {
                continue;
            } // skip unresolved
            $resp = $needsAuth ? $this->actingAs($this->user)->get($url) : $this->get($url);
            $code = $resp->getStatusCode();
            $checked++;
            // aceitável: 200, 302/redirect (compat), 403? não. 500 = erro
            if ($code >= 500) {
                $failures[] = "$url => $code";
                // dump exception content snippet
                try {
                    $c = substr(strip_tags($resp->getContent()), 0, 300);
                    $failures[count($failures) - 1] .= ' | '.preg_replace('/\s+/', ' ', $c);
                } catch (\Throwable $e) {
                }
            }
            echo str_pad($url, 32)." [$code]\n";
        }
        echo "\nChecked: $checked | Failures(5xx): ".count($failures)."\n";
        foreach ($failures as $f) {
            echo "FAIL: $f\n";
        }
        $this->assertEmpty($failures, 'Páginas com erro 500: '.implode('; ',$failures));
    }
}
