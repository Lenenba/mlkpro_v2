<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function index()
    {
        $lastCustomers = Customer::mostRecent()->paginate(5);
        $lastWorks = Work::mostRecent()->paginate(5);
        $mustUseProducts = Product::mustUse()->paginate(5);
        $customers = Customer::all();
        $work = Work::all();
        $product = Product::all();

         // Pass data to Inertia view
         return Inertia::render('Dashboard', [
                'customers' => $customers,
                'lastCustomers' => $lastCustomers,
                'work' => $work,
                'product' => $product,
        ]);
    }
}
