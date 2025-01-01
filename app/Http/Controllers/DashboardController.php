<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $user_id = Auth::user()->id;
        $lastCustomers = Customer::mostRecent()->byUser($user_id)->paginate(5);
        $lastWorks = Work::mostRecent()->byUser($user_id)->paginate(5);

        $customers = Customer::byUser($user_id)->get();
        $products = Product::byUser($user_id)->get();
        $works = Work::byUser($user_id)->get();

        $quotesWorks = Work::ByCategory('Quotes')->byUser($user_id)->paginate(50);
        $estimatesWorks = Work::ByCategory('Estimations')->byUser($user_id)->paginate(50);
        $jobsWorks = Work::ByCategory('Jobs')->byUser($user_id)->paginate(50);

        // Pass data to Inertia view
        return Inertia::render('Dashboard', [
            'customers' => $customers,
            'products' => $products,
            'works' => $works,
            'lastCustomers' => $lastCustomers,
            'lastWorks' => $lastWorks,
            'quotesWorks' => $quotesWorks,
            'jobsWorks' => $jobsWorks,
            'estimatesWorks' => $estimatesWorks,
        ]);
    }
}
