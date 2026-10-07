<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('branch_id')->nullable();
            $t->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $t->foreignId('pet_id')->constrained()->cascadeOnDelete();
            $t->foreignId('professional_id')->nullable();
            $t->foreignId('service_id')->nullable();
            $t->string('type')->default('bath');
            $t->string('status')->default('pending');
            $t->dateTime('scheduled_at');
            $t->dateTime('ends_at')->nullable();
            $t->decimal('price', 10, 2)->default(0);
            $t->text('notes')->nullable();
            $t->text('preferences')->nullable();
            $t->text('cancellation_reason')->nullable();
            $t->timestamps();
            $t->index(['business_id', 'scheduled_at']);
            $t->index(['business_id', 'status']);
            $t->index(['professional_id', 'scheduled_at']);
        });
        Schema::create('appointment_status_histories', function (Blueprint $t) {
            $t->id();
            $t->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $t->string('from_status')->nullable();
            $t->string('to_status');
            $t->foreignId('user_id')->nullable();
            $t->timestamp('created_at')->useCurrent();
        });
        Schema::create('grooming_records', function (Blueprint $t) {
            $t->id();
            $t->foreignId('appointment_id')->nullable();
            $t->foreignId('pet_id')->constrained()->cascadeOnDelete();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('professional_id')->nullable();
            $t->string('type')->default('bath');
            $t->string('status')->default('scheduled');
            $t->string('machine')->nullable();
            $t->string('blade_height')->nullable();
            $t->string('behavior')->nullable();
            $t->json('products_used')->nullable();
            $t->text('notes')->nullable();
            $t->dateTime('started_at')->nullable();
            $t->dateTime('finished_at')->nullable();
            $t->string('before_photo')->nullable();
            $t->string('after_photo')->nullable();
            $t->timestamps();
        });
        Schema::create('daycare_records', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('branch_id')->nullable();
            $t->foreignId('pet_id')->constrained()->cascadeOnDelete();
            $t->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $t->date('date');
            $t->string('check_in')->nullable();
            $t->string('check_out')->nullable();
            $t->string('status')->default('scheduled');
            $t->json('activities')->nullable();
            $t->text('feeding')->nullable();
            $t->string('behavior')->nullable();
            $t->text('notes')->nullable();
            $t->decimal('price', 10, 2)->default(0);
            $t->timestamps();
        });
        Schema::create('boarding_records', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('branch_id')->nullable();
            $t->foreignId('pet_id')->constrained()->cascadeOnDelete();
            $t->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $t->string('unit')->nullable();
            $t->dateTime('check_in');
            $t->dateTime('check_out')->nullable();
            $t->string('status')->default('reserved');
            $t->text('feeding')->nullable();
            $t->text('medication')->nullable();
            $t->text('activities')->nullable();
            $t->text('notes')->nullable();
            $t->decimal('price', 10, 2)->default(0);
            $t->timestamps();
        });
        Schema::create('commissions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('professional_id')->constrained()->cascadeOnDelete();
            $t->foreignId('appointment_id')->nullable();
            $t->decimal('amount', 10, 2);
            $t->decimal('pct', 5, 2);
            $t->string('status')->default('pending');
            $t->dateTime('paid_at')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['commissions', 'boarding_records', 'daycare_records', 'grooming_records', 'appointment_status_histories', 'appointments'] as $tb) {
            Schema::dropIfExists($tb);
        }
    }
};
