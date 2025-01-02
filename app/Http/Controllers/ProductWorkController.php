<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\Product;
use App\Notifications\LowStock;
use Illuminate\Http\Request;

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
        $product = Product::findOrFail($validated['product_id']);

        // Vérifier si le produit est en stock
        if ($product->stock < $validated['quantity_used']) {
            return redirect()->back()->with('error', 'Not enough stock for this product.');
        }

        // Vérifier si le produit existe déjà dans ce travail
        $existingProduct = $work->products()
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingProduct) {
            // Mettre à jour la quantité utilisée si le produit existe déjà
            $work->products()->updateExistingPivot($validated['product_id'], [
                'quantity_used' => $existingProduct->pivot->quantity_used + $validated['quantity_used'],
            ]);
            // Diminuer le stock du produit
            $product->stock -= $validated['quantity_used'];
            $product->save();
        } else {
            // Attacher le produit avec la nouvelle quantité et unité
            $work->products()->attach($validated['product_id'], [
                'quantity_used' => $validated['quantity_used'],
                'unit' => $validated['unit'],
            ]);
            // Diminuer le stock du produit
            $product->stock -= $validated['quantity_used'];
            $product->save();
        }

        // Check if stock reaches or goes below minimum level
        if ($product->stock <= $product->minimum_stock) {
            // Notify the product owner or admin
            $product->user->notify(new LowStock($product));
        }

        // Charger le client et ses travaux pour la redirection
        $customer = $work->customer->load('works');

        // Mettre à jour le prix du travail
        $this->updateWorkCost($work);

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
        // Vérifier la quantité utilisée avant de détacher
        $productPivot = $work->products()->where('product_id', $product->id)->first();
        if ($productPivot) {
            $quantityUsed = $productPivot->pivot->quantity_used;

            // Détacher le produit du travail
            $work->products()->detach($product->id);

            // Ajouter le stock du produit
            $product->stock += $quantityUsed;
            $product->save();
        }

        // Mettre à jour le prix du travail
        $this->updateWorkCost($work);

        // Charger le client et ses travaux pour la redirection
        $customer = $work->customer->load('works');

        return redirect()->route('work.edit', [
            'work_id' => $work->id,
            'work' => $work,
            'customer' => $customer
        ])->with('success', 'Product removed successfully.');
    }

    /**
     * Update the total cost of the work based on the products attached.
     *
     * @param \App\Models\Work $work
     * @return void
     */
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
