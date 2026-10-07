<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', fn (Blueprint $t) => [$t->id(), $t->string('name'), $t->string('slug')->unique(), $t->string('document')->nullable(), $t->string('email')->nullable(), $t->string('phone')->nullable(), $t->string('plan')->default('trial'), $t->string('status')->default('active'), $t->json('settings')->nullable(), $t->timestamps(), $t->softDeletes()]);
        Schema::create('branches', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->string('code');
            $t->string('address')->nullable();
            $t->string('phone')->nullable();
            $t->string('email')->nullable();
            $t->string('opening_hours')->nullable();
            $t->string('manager')->nullable();
            $t->string('status')->default('active');
            $t->timestamps();
            $t->unique(['business_id', 'code']);
        });
        Schema::table('users', function (Blueprint $t) {
            $t->foreignId('current_business_id')->nullable()->after('remember_token');
            $t->foreignId('current_branch_id')->nullable()->after('current_business_id');
            $t->string('phone')->nullable();
            $t->string('avatar')->nullable();
            $t->string('status')->default('active');
        });
        Schema::create('business_user', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('role')->default('owner');
            $t->foreignId('branch_id')->nullable();
            $t->timestamps();
            $t->unique(['business_id', 'user_id']);
        });
        Schema::create('pet_species', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->string('icon')->nullable();
            $t->string('status')->default('active');
            $t->timestamps();
        });
        Schema::create('pet_breeds', function (Blueprint $t) {
            $t->id();
            $t->foreignId('species_id')->constrained('pet_species')->cascadeOnDelete();
            $t->foreignId('business_id')->nullable();
            $t->string('name');
            $t->string('size')->nullable();
            $t->boolean('custom')->default(false);
            $t->timestamps();
        });
        Schema::create('service_categories', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->string('color')->default('#EC4899');
            $t->string('icon')->nullable();
            $t->timestamps();
        });
        Schema::create('services', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('category_id')->nullable();
            $t->string('name');
            $t->text('description')->nullable();
            $t->integer('duration_min')->default(60);
            $t->decimal('price', 10, 2)->default(0);
            $t->decimal('cost', 10, 2)->default(0);
            $t->decimal('commission_pct', 5, 2)->default(10);
            $t->string('status')->default('active');
            $t->timestamps();
            $t->index(['business_id', 'status']);
        });
        Schema::create('professionals', function (Blueprint $t) {
            $t->id();
            $t->foreignId('business_id')->constrained()->cascadeOnDelete();
            $t->foreignId('branch_id')->nullable();
            $t->foreignId('user_id')->nullable();
            $t->string('name');
            $t->string('document')->nullable();
            $t->string('email')->nullable();
            $t->string('phone')->nullable();
            $t->string('role')->default('groomer');
            $t->json('specialties')->nullable();
            $t->decimal('commission_pct', 5, 2)->default(10);
            $t->string('status')->default('active');
            $t->string('color')->default('#EC4899');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professionals');
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_categories');
        Schema::dropIfExists('pet_breeds');
        Schema::dropIfExists('pet_species');
        Schema::dropIfExists('business_user');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('businesses');
    }
};
