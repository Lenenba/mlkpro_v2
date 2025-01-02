<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductWorkController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'work_id' => 'required|exists:works,id',
            'quantity_used' => 'required|integer|min:1',
            'unit' => 'required|string',
        ]);

        $work = Work::with(['customer', 'products', 'ratings'])->findOrFail($validated['work_id']);

        // Vérifier si le produit existe déjà dans ce travail
        $existingProduct = $work->products()
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingProduct) {
            // Mettre à jour la quantité utilisée si le produit existe déjà
            $work->products()->updateExistingPivot($validated['product_id'], [
                'quantity_used' => $existingProduct->pivot->quantity_used + $validated['quantity_used'],
            ]);
        } else {
            // Attacher le produit avec la nouvelle quantité et unité
            $work->products()->attach($validated['product_id'], [
                'quantity_used' => $validated['quantity_used'],
                'unit' => $validated['unit'],
            ]);
        }

        // Charger le client et ses travaux pour la redirection
        $customer = $work->customer->load('works');

        return redirect()->route('work.edit', [
            'work_id' => $work->id,
            'work' => $work,
            'customer' => $customer
        ])->with('success', 'Product added successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Work  $work
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy(Work $work, Product $product)
    {
        $work->products()->detach($product->id);

        $customer = $work->customer->load('works');

        return redirect()->route('work.edit', [
            'work_id' => $work->id,
            'work' => $work,
            'customer' => $customer
        ])->with('success', 'product removed successfully.');
    }
}
