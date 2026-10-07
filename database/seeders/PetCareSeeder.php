<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Business;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\LoyaltyAccount;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Pet;
use App\Models\PetBreed;
use App\Models\PetSpecies;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Professional;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\Vaccine;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PetCareSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Cães' => '🐶', 'Gatos' => '🐱', 'Aves' => '🦜', 'Roedores' => '🐹', 'Répteis' => '🦎'] as $n => $i) {
            $sp = PetSpecies::firstOrCreate(['name' => $n], ['icon' => $i]);
        }
        $dog = PetSpecies::where('name', 'Cães')->first();
        $cat = PetSpecies::where('name', 'Gatos')->first();
        $biz = Business::create(['name' => 'Patinhas & Cia', 'slug' => 'patinhas-cia', 'email' => 'contato@patinhas.test', 'phone' => '11999990000']);
        $br = Branch::create(['business_id' => $biz->id, 'name' => 'Unidade Centro', 'code' => 'CTR', 'address' => 'Rua das Flores, 123']);
        $demo = User::where('email', 'demo@petcareos.test')->first() ?? User::create(['name' => 'Demo', 'email' => 'demo@petcareos.test', 'password' => 'password', 'current_business_id' => $biz->id]);
        $demo->update(['current_business_id' => $biz->id]);
        $demo->businesses()->syncWithoutDetaching([$biz->id => ['role' => 'owner']]);
        foreach (['Shih Tzu', 'Poodle', 'Golden Retriever', 'Bulldog', 'Yorkshire'] as $b) {
            PetBreed::firstOrCreate(['name' => $b, 'species_id' => $dog->id]);
        }
        foreach (['Persa', 'Siamês', 'SRD Felino'] as $b) {
            PetBreed::firstOrCreate(['name' => $b, 'species_id' => $cat->id]);
        }
        $cat1 = ServiceCategory::create(['business_id' => $biz->id, 'name' => 'Banho', 'color' => '#EC4899']);
        $cat2 = ServiceCategory::create(['business_id' => $biz->id, 'name' => 'Tosa', 'color' => '#A855F7']);
        $svcB = Service::create(['business_id' => $biz->id, 'category_id' => $cat1->id, 'name' => 'Banho', 'duration_min' => 60, 'price' => 60]);
        $svcT = Service::create(['business_id' => $biz->id, 'category_id' => $cat2->id, 'name' => 'Tosa Completa', 'duration_min' => 90, 'price' => 110]);
        $svcD = Service::create(['business_id' => $biz->id, 'category_id' => $cat1->id, 'name' => 'Daycare', 'duration_min' => 480, 'price' => 70]);
        $pro = Professional::create(['business_id' => $biz->id, 'branch_id' => $br->id, 'name' => 'Ana Groomer', 'role' => 'groomer', 'specialties' => ['Banho', 'Tosa'], 'commission_pct' => 15]);
        Professional::create(['business_id' => $biz->id, 'branch_id' => $br->id, 'name' => 'Carlos Banho', 'role' => 'bath', 'specialties' => ['Banho'], 'commission_pct' => 10]);
        ProductCategory::create(['business_id' => $biz->id, 'name' => 'Rações']);
        Product::create(['business_id' => $biz->id, 'name' => 'Ração Premium 10kg', 'sku' => 'RAC-10', 'price' => 189.9, 'cost' => 120, 'stock' => 25, 'min_stock' => 5]);
        Product::create(['business_id' => $biz->id, 'name' => 'Shampoo Neutro 500ml', 'sku' => 'SHP-500', 'price' => 39.9, 'cost' => 18, 'stock' => 3, 'min_stock' => 5]);
        Coupon::create(['business_id' => $biz->id, 'code' => 'BEMVINDO10', 'type' => 'percentage', 'value' => 10, 'status' => 'active']);
        Package::create(['business_id' => $biz->id, 'name' => 'Pacote 4 Banhos', 'price' => 180, 'validity_days' => 30, 'services' => [$svcB->id]]);
        SubscriptionPlan::create(['business_id' => $biz->id, 'name' => 'Plano Premium', 'price' => 299, 'cycle' => 'monthly', 'services' => [$svcB->id, $svcT->id]]);
        $faker = Factory::create('pt_BR');
        for ($i = 0; $i < 60; $i++) {
            $c = Customer::create(['business_id' => $biz->id, 'branch_id' => $br->id, 'name' => $faker->name, 'email' => $faker->unique()->safeEmail, 'phone' => $faker->phoneNumber, 'status' => 'active', 'loyalty_points' => rand(0, 400)]);
            LoyaltyAccount::create(['business_id' => $biz->id, 'customer_id' => $c->id, 'points' => $c->loyalty_points, 'total_earned' => $c->loyalty_points]);
            $np = rand(1, 2);
            for ($p = 0; $p < $np; $p++) {
                $pet = Pet::create(['business_id' => $biz->id, 'customer_id' => $c->id, 'species_id' => $dog->id, 'breed_id' => PetBreed::inRandomOrder()->first()->id, 'name' => $faker->firstName, 'sex' => rand(0, 1) ? 'M' : 'F', 'birth_date' => now()->subMonths(rand(6, 80)), 'weight' => rand(30, 350) / 10, 'size' => 'M', 'temperament' => 'Sociável', 'status' => 'active']);
                if (rand(0, 3) === 0) {
                    Vaccine::create(['pet_id' => $pet->id, 'business_id' => $biz->id, 'name' => 'V10', 'date' => now()->subMonths(11), 'next_dose' => now()->addDays(rand(1, 40))]);
                }
                for ($a = 0; $a < rand(1, 4); $a++) {
                    $dt = now()->subDays(rand(0, 30))->setTime(rand(8, 18), [0, 30][rand(0, 1)]);
                    Appointment::create(['business_id' => $biz->id, 'branch_id' => $br->id, 'customer_id' => $c->id, 'pet_id' => $pet->id, 'professional_id' => $pro->id, 'service_id' => [$svcB->id, $svcT->id, $svcD->id][rand(0, 2)], 'type' => 'bath', 'status' => ['pending', 'confirmed', 'completed', 'completed'][rand(0, 3)], 'scheduled_at' => $dt, 'ends_at' => (clone $dt)->addHour(), 'price' => [60, 110, 70][rand(0, 2)]]);
                }
                Payment::create(['business_id' => $biz->id, 'branch_id' => $br->id, 'customer_id' => $c->id, 'method' => ['pix', 'cash', 'credit_card'][rand(0, 2)], 'status' => 'paid', 'amount' => rand(60, 300), 'paid_at' => now()->subDays(rand(0, 14))]);
            }
        }
        foreach (['Novo Lead', 'Contato', 'Interessado'] as $s) {
            Lead::create(['business_id' => $biz->id, 'name' => Factory::create('pt_BR')->name, 'phone' => '11988887777', 'status' => ['new_lead', 'contacted', 'interested'][rand(0,2)], 'interest' => 'Banho']);
        }
    }
}
