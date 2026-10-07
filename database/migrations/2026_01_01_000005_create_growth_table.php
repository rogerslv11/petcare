<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->text('description')->nullable();
            $t->decimal('price', 10, 2);
            $t->integer('validity_days')->default(30);
            $t->string('status')->default('active');
            $t->json('services')->nullable();
            $t->timestamps();
        });
        Schema::create('package_credits', function (Blueprint $t) {
            $t->id();
            $t->foreignId('package_id')->constrained()->cascadeOnDelete();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $t->foreignId('pet_id')->nullable();
            $t->integer('total_credits');
            $t->integer('used_credits')->default(0);
            $t->date('expires_at')->nullable();
            $t->string('status')->default('active');
            $t->timestamps();
        });
        Schema::create('subscription_plans', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->decimal('price', 10, 2);
            $t->string('cycle')->default('monthly');
            $t->json('services')->nullable();
            $t->json('benefits')->nullable();
            $t->string('status')->default('active');
            $t->timestamps();
        });
        Schema::create('subscriptions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('plan_id')->constrained('subscription_plans')->cascadeOnDelete();
            $t->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $t->foreignId('pet_id')->nullable();
            $t->string('status')->default('active');
            $t->date('started_at')->nullable();
            $t->date('ends_at')->nullable();
            $t->decimal('price', 10, 2);
            $t->timestamps();
        });
        Schema::create('coupons', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->string('code');
            $t->string('type')->default('percentage');
            $t->decimal('value', 10, 2);
            $t->decimal('min_value', 10, 2)->default(0);
            $t->integer('usage_limit')->nullable();
            $t->integer('used')->default(0);
            $t->date('starts_at')->nullable();
            $t->date('ends_at')->nullable();
            $t->string('status')->default('active');
            $t->timestamps();
            $t->unique(['business_id', 'code']);
        });
        Schema::create('loyalty_accounts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $t->integer('points')->default(0);
            $t->integer('total_earned')->default(0);
            $t->integer('total_redeemed')->default(0);
            $t->timestamps();
            $t->unique(['business_id', 'customer_id']);
        });
        Schema::create('loyalty_transactions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('loyalty_account_id')->constrained()->cascadeOnDelete();
            $t->integer('points');
            $t->string('type');
            $t->string('description')->nullable();
            $t->timestamps();
        });
        Schema::create('leads', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->string('phone')->nullable();
            $t->string('email')->nullable();
            $t->string('source')->nullable();
            $t->string('interest')->nullable();
            $t->string('status')->default('new_lead');
            $t->dateTime('last_contact_at')->nullable();
            $t->dateTime('next_contact_at')->nullable();
            $t->text('notes')->nullable();
            $t->timestamps();
        });
        Schema::create('activity_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->nullable();
            $t->foreignId('user_id')->nullable();
            $t->string('action');
            $t->string('entity_type')->nullable();
            $t->unsignedBigInteger('entity_id')->nullable();
            $t->string('ip')->nullable();
            $t->json('meta')->nullable();
            $t->timestamps();
            $t->index(['business_id', 'created_at']);
        });
        Schema::create('webhooks', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->string('url');
            $t->string('secret')->nullable();
            $t->json('events')->nullable();
            $t->string('status')->default('active');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['webhooks', 'activity_logs', 'leads', 'loyalty_transactions', 'loyalty_accounts', 'coupons', 'subscriptions', 'subscription_plans', 'package_credits', 'packages'] as $tb) {
            Schema::dropIfExists($tb);
        }
    }
};
