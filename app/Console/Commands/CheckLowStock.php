<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LowStockAlert;

class CheckLowStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:check-low-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for products with low stock and notify users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch all products where stock is less than or equal to the minimum stock level.
        $products = Product::whereColumn('stock', '<=', 'minimum_stock')->get();

        if ($products->isEmpty()) {
            // Log a message if no low stock products are found.
            $this->info('No products with low stock found.');
            return;
        }

        // Iterate through each product and send notifications.
        foreach ($products as $product) {
            // Notify the admin or responsible users about the low stock.
            Notification::route('mail', 'admin@example.com')
                ->notify(new LowStockAlert($product));
        }

        // Inform in the console that the notifications have been sent.
        $this->info('Low stock alerts sent for ' . $products->count() . ' products.');
    }
}
