<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\StockMovement;
use Livewire\Component;

class InventoryDashboard extends Component
{
    public string $q = '';

    public function adjust(int $id, int $qty, string $type)
    {
        $p = Product::findOrFail($id);
        $p->increment('stock', $type === 'out' ? -$qty : $qty);
        StockMovement::create(['business_id' => $p->business_id, 'product_id' => $p->id, 'user_id' => auth()->id(), 'type' => $type, 'qty' => $qty, 'reason' => 'ajuste manual']);
    }

    public function render()
    {
        $low = Product::whereColumn('stock', '<=', 'min_stock')->count();
        $total = Product::count();
        $value = Product::sum(\DB::raw('stock*cost'));
        $rows = Product::when($this->q, fn ($x) => $x->where('name', 'like', "%{$this->q}%"))->paginate(12);

        return view('livewire.inventory-dashboard', compact('low', 'total', 'value', 'rows'));
    }
}
