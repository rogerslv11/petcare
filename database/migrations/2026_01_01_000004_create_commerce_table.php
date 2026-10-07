<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->timestamps();
        });
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('category_id')->nullable();
            $t->string('name');
            $t->string('sku')->nullable();
            $t->string('barcode')->nullable();
            $t->decimal('price', 10, 2)->default(0);
            $t->decimal('cost', 10, 2)->default(0);
            $t->integer('stock')->default(0);
            $t->integer('min_stock')->default(5);
            $t->string('image')->nullable();
            $t->string('status')->default('active');
            $t->timestamps();
            $t->index(['business_id', 'status']);
        });
        Schema::create('stock_movements', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('branch_id')->nullable();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->nullable();
            $t->string('type');
            $t->integer('qty');
            $t->string('reason')->nullable();
            $t->timestamps();
        });
        Schema::create('suppliers', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->string('document')->nullable();
            $t->string('contact')->nullable();
            $t->string('phone')->nullable();
            $t->string('email')->nullable();
            $t->string('address')->nullable();
            $t->text('notes')->nullable();
            $t->timestamps();
        });
        Schema::create('purchase_orders', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $t->string('status')->default('draft');
            $t->decimal('total', 10, 2)->default(0);
            $t->date('expected_at')->nullable();
            $t->text('notes')->nullable();
            $t->timestamps();
        });
        Schema::create('purchase_order_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('purchase_order_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->integer('qty');
            $t->decimal('unit_cost', 10, 2);
        });
        Schema::create('sales', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('branch_id')->nullable();
            $t->foreignId('customer_id')->nullable();
            $t->foreignId('pet_id')->nullable();
            $t->foreignId('user_id')->nullable();
            $t->decimal('subtotal', 10, 2)->default(0);
            $t->decimal('discount', 10, 2)->default(0);
            $t->decimal('total', 10, 2)->default(0);
            $t->string('coupon_code')->nullable();
            $t->text('notes')->nullable();
            $t->string('status')->default('completed');
            $t->timestamps();
        });
        Schema::create('sale_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('sale_id')->constrained()->cascadeOnDelete();
            $t->string('item_type');
            $t->unsignedBigInteger('item_id')->nullable();
            $t->string('name');
            $t->integer('qty')->default(1);
            $t->decimal('unit_price', 10, 2);
            $t->decimal('total', 10, 2);
        });
        Schema::create('payments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('branch_id')->nullable();
            $t->foreignId('customer_id')->nullable();
            $t->foreignId('sale_id')->nullable();
            $t->foreignId('appointment_id')->nullable();
            $t->string('method')->default('pix');
            $t->string('status')->default('pending');
            $t->decimal('amount', 10, 2);
            $t->decimal('discount', 10, 2)->default(0);
            $t->decimal('fee', 10, 2)->default(0);
            $t->dateTime('paid_at')->nullable();
            $t->date('due_date')->nullable();
            $t->text('notes')->nullable();
            $t->timestamps();
            $t->index(['business_id', 'status']);
        });
        Schema::create('cash_registers', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('branch_id')->nullable();
            $t->foreignId('user_id')->nullable();
            $t->string('status')->default('open');
            $t->dateTime('opened_at')->nullable();
            $t->dateTime('closed_at')->nullable();
            $t->decimal('opening_balance', 10, 2)->default(0);
            $t->decimal('closing_balance', 10, 2)->nullable();
            $t->text('notes')->nullable();
            $t->timestamps();
        });
        Schema::create('cash_movements', function (Blueprint $t) {
            $t->id();
            $t->foreignId('cash_register_id')->constrained()->cascadeOnDelete();
            $t->string('type');
            $t->decimal('amount', 10, 2);
            $t->text('description')->nullable();
            $t->string('method')->default('cash');
            $t->timestamps();
        });
        Schema::create('financial_transactions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('branch_id')->nullable();
            $t->string('type');
            $t->string('category')->nullable();
            $t->string('description');
            $t->decimal('amount', 10, 2);
            $t->date('date');
            $t->string('status')->default('paid');
            $t->timestamps();
            $t->index(['business_id', 'date']);
        });
    }

    public function down(): void
    {
        foreach (['financial_transactions', 'cash_movements', 'cash_registers', 'payments', 'sale_items', 'sales', 'purchase_order_items', 'purchase_orders', 'suppliers', 'stock_movements', 'products', 'product_categories'] as $tb) {
            Schema::dropIfExists($tb);
        }
    }
};
