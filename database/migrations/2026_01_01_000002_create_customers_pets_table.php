<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('branch_id')->nullable();
            $t->string('name');
            $t->string('document')->nullable();
            $t->string('email')->nullable();
            $t->string('phone')->nullable();
            $t->string('whatsapp')->nullable();
            $t->date('birth_date')->nullable();
            $t->string('address')->nullable();
            $t->string('city')->nullable();
            $t->string('state', 2)->nullable();
            $t->string('zip')->nullable();
            $t->text('notes')->nullable();
            $t->string('status')->default('active');
            $t->integer('loyalty_points')->default(0);
            $t->json('custom_fields')->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['business_id', 'status']);
            $t->index(['business_id', 'name']);
        });
        Schema::create('pets', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $t->foreignId('species_id')->nullable();
            $t->foreignId('breed_id')->nullable();
            $t->string('name');
            $t->string('photo')->nullable();
            $t->string('sex')->default('M');
            $t->date('birth_date')->nullable();
            $t->decimal('weight', 5, 2)->nullable();
            $t->string('color')->nullable();
            $t->string('size')->nullable();
            $t->string('microchip')->nullable();
            $t->string('temperament')->nullable();
            $t->string('behavior')->nullable();
            $t->text('notes')->nullable();
            $t->string('status')->default('active');
            $t->text('allergies_summary')->nullable();
            $t->json('custom_fields')->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['business_id', 'customer_id']);
        });
        Schema::create('pet_photos', function (Blueprint $t) {
            $t->id();
            $t->foreignId('pet_id')->constrained()->cascadeOnDelete();
            $t->foreignId('appointment_id')->nullable();
            $t->string('path');
            $t->string('stage')->default('after');
            $t->string('caption')->nullable();
            $t->timestamps();
        });
        Schema::create('pet_allergies', function (Blueprint $t) {
            $t->id();
            $t->foreignId('pet_id')->constrained()->cascadeOnDelete();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->string('type');
            $t->text('description');
            $t->string('severity')->default('medium');
            $t->timestamps();
        });
        Schema::create('vaccines', function (Blueprint $t) {
            $t->id();
            $t->foreignId('pet_id')->constrained()->cascadeOnDelete();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->date('date');
            $t->string('batch')->nullable();
            $t->string('manufacturer')->nullable();
            $t->date('next_dose')->nullable();
            $t->string('vet_name')->nullable();
            $t->text('notes')->nullable();
            $t->timestamps();
            $t->index('next_dose');
        });
        Schema::create('medications', function (Blueprint $t) {
            $t->id();
            $t->foreignId('pet_id')->constrained()->cascadeOnDelete();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->string('dosage')->nullable();
            $t->string('frequency')->nullable();
            $t->string('time')->nullable();
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->text('instructions')->nullable();
            $t->string('responsible')->nullable();
            $t->timestamps();
        });
        Schema::create('feeding_records', function (Blueprint $t) {
            $t->id();
            $t->foreignId('pet_id')->constrained()->cascadeOnDelete();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->string('food_type');
            $t->string('qty')->nullable();
            $t->string('time')->nullable();
            $t->text('notes')->nullable();
            $t->string('source')->default('house');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['feeding_records', 'medications', 'vaccines', 'pet_allergies', 'pet_photos', 'pets', 'customers'] as $tb) {
            Schema::dropIfExists($tb);
        }
    }
};
