<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\Product;
use App\Models\Customer;
use App\Models\ProductWork;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WorkController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the works.
     */
    public function index()
    {
        $works = Work::with(['customer', 'products', 'ratings'])
            ->orderBy('work_date', 'desc')
            ->paginate(10);

        return inertia('Work/Index', ['works' => $works]);
    }

    /**
     * Show the form for creating a new work.
     */
    public function create(Int $customer_id = null)
    {
        $customer = Customer::with('works')->findOrFail($customer_id);
        return inertia('Work/Create', ['customer' => $customer]);
    }

    /**
     * Display the specified work.
     */
    public function show($id)
    {
        $work = Work::with(['customer', 'products', 'ratings'])->findOrFail($id);

        $this->authorize('view', $work);
        return inertia('Work/Index', ['work' => $work]);
    }

    /**
     * Store a newly created work in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'type' => 'required|string',
            'description' => 'required|string',
            'work_date' => 'required|date',
            'time_spent' => 'nullable|integer|min:0',
            'cost' => 'nullable|numeric|min:0',
            'location' => 'nullable|string',
        ]);

        $customer = Customer::with(['works'])->findOrFail($validated['customer_id']);
        $validated['user_id'] = Auth::user()->id;
        $work =  $customer->works()->create($validated);

        return redirect()->route('work.edit',  [
            'work_id' => $work->id,
            'work' => $work,
            'customer' => $customer
        ])->with('success', 'Work created successfully.');
    }

    public function edit(int $work_id, ?Request $request)
    {
        $work = Work::with(['customer', 'products', 'ratings'])->findOrFail($work_id);
        $this->authorize('edit', $work);
        $filters = $request->only([
            'category_id',
            'name',
            'stock'
        ]);
        $workProducts = $work->products ?? [];

        $products = Product::mostRecent()
        ->filter($filters)
        ->with(['category','works'])
        ->simplePaginate(4)
        ->withQueryString();
        $categories = ProductCategory::all();
        $customer = $work->customer->load('works');


        return inertia('Work/Edit', [
            'work' => $work,
            'customer' => $customer,
            'filters' => $filters,
            'workProducts' => $workProducts,
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified work in storage.
     */
    public function update(Request $request, $id)
    {
        $work = Work::findOrFail($id);

        $validated = $request->validate([
            'description' => 'nullable|string',
            'work_date' => 'nullable|date',
            'time_spent' => 'nullable|integer|min:0',
            'is_completed' => 'nullable|boolean',
            'cost' => 'nullable|numeric|min:0',
            'location' => 'nullable|string',
            'products' => 'array',
            'products.*.product_id' => 'required_with:products|exists:products,id',
            'products.*.quantity_used' => 'required_with:products|integer|min:1',
        ]);

        $work->update($validated);

        // Update products if provided
        if ($request->has('products')) {
            ProductWork::where('work_id', $work->id)->delete();

            foreach ($validated['products'] as $product) {
                ProductWork::create([
                    'work_id' => $work->id,
                    'product_id' => $product['product_id'],
                    'quantity_used' => $product['quantity_used'],
                ]);
            }
        }

        return response()->json(['message' => 'Work updated successfully', 'work' => $work]);
    }

    /**
     * Remove the specified work from storage.
     */
    public function destroy($id)
    {
        $work = Work::findOrFail($id);
        $work->delete();

        return response()->json(['message' => 'Work deleted successfully']);
    }
}
