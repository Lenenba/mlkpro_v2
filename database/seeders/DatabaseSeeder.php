<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Work;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use App\Models\WorkRating;
use App\Models\ProductWork;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users
        $users = User::factory(3)->create();

        // Create product categories
        $categories = ProductCategory::factory(5)->create();

        // Create products and associate with categories and users
        $Products = Product::factory(20)
            ->recycle($categories)
            ->recycle($users)
            ->create();

        foreach ($Products as $product) {
            $product->number = 'PROD' . str_pad($product->id, 6, '0', STR_PAD_LEFT);
            $product->save();
        }

        // Create customers and associate with users
        $customers = Customer::factory(10)
            ->recycle($users)
            ->create();

        foreach ($customers as $customer) {
            $customer->number = 'CUST' . str_pad($customer->id, 6, '0', STR_PAD_LEFT);
            $customer->save();
        }

        // Create works and associate with users and customers
        $works = Work::factory(50)
            ->recycle($users)
            ->recycle(Customer::all())
            ->create();

        foreach ($works as $work) {
            $work->number = 'WORK' . str_pad($work->id, 6, '0', STR_PAD_LEFT);
            $this->updateWorkCost($work);
            $work->save();
        }
        // Create product usage for works
        ProductWork::factory(30)
            ->recycle($works)
            ->recycle(Product::all())
            ->create();


        // Create worker ratings for works
        WorkRating::factory(10)
            ->recycle($works)
            ->recycle($users)
            ->create();

            // Create invoices for works
        foreach ($works as $work) {
            Invoice::factory()->create([
                'customer_id' => $work->customer_id,
                'user_id' => $work->user_id,
                'work_id' => $work->id,
                'total' => $work->cost,
                'status' => 'pending',
            ]);
        }

        foreach (Invoice::all() as $invoice) {
            $invoice->number = 'INV' . str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
            $invoice->save();
        }
    }

    private function updateWorkCost(Work $work)
    {
        // Calculer le coût total des produits ajoutés
        $productsCost = 0;

        foreach ($work->products as $product) {
            $productsCost += $product->price * $product->pivot->quantity_used;
        }

        // Mettre à jour le coût du travail, en ajoutant les produits au prix de base
        $work->cost = $work->base_cost + $productsCost;
        $work->save();
    }

}
