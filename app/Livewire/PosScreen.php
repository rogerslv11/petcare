<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Service;
use App\Services\SaleService;
use App\Support\TenantContext;
use Livewire\Component;

class PosScreen extends Component
{
    public array $cart = [];

    public $customer_id = null;

    public string $coupon = '';

    public float $discount = 0;

    public string $method = 'pix';

    public string $q = '';

    public function addProduct(int $id)
    {
        $p = Product::findOrFail($id);
        $this->cart[] = ['item_type' => 'product', 'item_id' => $p->id, 'name' => $p->name, 'qty' => 1, 'unit_price' => $p->price];
    }

    public function addService(int $id)
    {
        $s = Service::findOrFail($id);
        $this->cart[] = ['item_type' => 'service', 'item_id' => $s->id, 'name' => $s->name, 'qty' => 1, 'unit_price' => $s->price];
    }

    public function remove(int $i)
    {
        unset($this->cart[$i]);
        $this->cart = array_values($this->cart);
    }

    public function getTotalProperty()
    {
        return collect($this->cart)->sum(fn ($i) => $i['qty'] * $i['unit_price']) - $this->discount;
    }

    public function finish(SaleService $svc)
    {
        $sale = $svc->checkout(['business_id' => TenantContext::businessId(), 'branch_id' => session('current_branch_id'), 'customer_id' => $this->customer_id, 'items' => $this->cart, 'discount' => $this->discount, 'coupon_code' => $this->coupon, 'method' => $this->method]);
        $this->cart = [];
        $this->dispatch('notify', message: 'Venda #'.$sale->id.' concluída ✅');
    }

    public function render()
    {
        $products = Product::where('name', 'like', "%{$this->q}%")->limit(8)->get();
        $services = Service::active()->limit(6)->get();
        $customers = Customer::limit(100)->get();

        return view('livewire.pos-screen', compact('products', 'services', 'customers'));
    }
}
