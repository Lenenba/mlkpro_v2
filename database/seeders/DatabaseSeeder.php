<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Work;
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
    }
}
