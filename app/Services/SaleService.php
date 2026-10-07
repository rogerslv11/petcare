<?php

namespace App\Services;

use App\Events\PaymentReceived;
use App\Models\Coupon;
use App\Models\LoyaltyAccount;
use App\Models\LoyaltyTransaction;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public function checkout(array $data): Sale
    {
        return DB::transaction(function () use ($data) {
            $subtotal = collect($data['items'])->sum(fn ($i) => $i['qty'] * $i['unit_price']);
            $discount = $data['discount'] ?? 0;
            if (! empty($data['coupon_code'])) {
                $c = Coupon::where('business_id', $data['business_id'])->where('code', $data['coupon_code'])->where('status', 'active')->first();
                if ($c) {
                    $discount += $c->type === 'percentage' ? $subtotal * $c->value / 100 : $c->value;
                    $c->increment('used');
                }
            }
            $sale = Sale::create(['business_id' => $data['business_id'], 'branch_id' => $data['branch_id'] ?? null, 'customer_id' => $data['customer_id'] ?? null, 'pet_id' => $data['pet_id'] ?? null, 'user_id' => auth()->id(), 'subtotal' => $subtotal, 'discount' => $discount, 'total' => max(0, $subtotal - $discount), 'coupon_code' => $data['coupon_code'] ?? null, 'status' => 'completed']);
            foreach ($data['items'] as $i) {
                SaleItem::create(['sale_id' => $sale->id, 'item_type' => $i['item_type'] ?? 'product', 'item_id' => $i['item_id'] ?? null, 'name' => $i['name'], 'qty' => $i['qty'], 'unit_price' => $i['unit_price'], 'total' => $i['qty'] * $i['unit_price']]);
                if (($i['item_type'] ?? '') === 'product' && isset($i['item_id'])) {
                    $p = Product::withoutGlobalScope('business')->find($i['item_id']);
                    if ($p) {
                        $p->decrement('stock', $i['qty']);
                        StockMovement::create(['business_id' => $sale->business_id, 'branch_id' => $sale->branch_id, 'product_id' => $p->id, 'user_id' => auth()->id(), 'type' => 'out', 'qty' => $i['qty'], 'reason' => 'sale #'.$sale->id]);
                    }
                }
            }
            Payment::create(['business_id' => $sale->business_id, 'branch_id' => $sale->branch_id, 'customer_id' => $sale->customer_id, 'sale_id' => $sale->id, 'method' => $data['method'] ?? 'pix', 'status' => 'paid', 'amount' => $sale->total, 'paid_at' => now()]);
            if ($sale->customer_id) {
                $this->earnLoyalty($sale);
            }
            event(new PaymentReceived($sale->total, $sale->business_id));

            return $sale;
        });
    }

    protected function earnLoyalty(Sale $sale): void
    {
        $acc = LoyaltyAccount::firstOrCreate(['business_id' => $sale->business_id, 'customer_id' => $sale->customer_id]);
        $pts = (int) floor($sale->total);
        $acc->increment('points', $pts);
        $acc->increment('total_earned', $pts);
        LoyaltyTransaction::create(['loyalty_account_id' => $acc->id, 'points' => $pts, 'type' => 'earn', 'description' => 'sale #'.$sale->id]);
    }
}
