<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{

    public function index(?Request $request)
    {
        $filters = $request->only(['name']);

        $invoices = Invoice::with('customer', 'work')
            ->latest()
            ->byUser(Auth::id())
            ->filter($filters)
            ->simplePaginate(12)
            ->withQueryString();

        return inertia('Invoice/Index', [
            'invoices' => $invoices,
            'filters' => $filters,
        ]);
    }


    public function generate($workId)
    {
        $work = Work::with('products')->findOrFail($workId);
        $customer = $work->customer;

        // Vérifiez si une facture existe déjà pour ce travail
        $invoice = $customer->invoices()->where('work_id', $work->id)->first();

        if ($invoice) {
            // Si une facture existe, téléchargez simplement le PDF associé
            Pdf::setOptions(['isRemoteEnabled' => true]); // Active l'accès aux images distantes
            $pdf = Pdf::loadView('invoices.template', compact('work', 'customer', 'invoice'));
            return $pdf->download("{$invoice->number}.pdf");
        }

        // Si aucune facture n'existe, en créer une nouvelle
        if ($customer) {
            $invoice = $customer->invoices()->create([
                'status' => 'pending',
                'total' => $this->calculateTotal($work),
                'work_id' => $work->id, // Lien avec le travail
                'user_id' => $work->user_id,
            ]);
        }

        // Assignez un numéro de facture unique
        $invoice->number = 'INV' . str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
        $invoice->save();

        // Mettre à jour le statut du travail, si nécessaire
        if ($work->is_completed === 0) {
            $work->update(['is_completed' => 1]);
        }

        // Créer un PDF
        Pdf::setOptions(['isRemoteEnabled' => true]); // Active l'accès aux images distantes
        $pdf = Pdf::loadView('invoices.template', compact('work', 'customer', 'invoice'));

        // Retourner le fichier PDF
        return $pdf->download("{$invoice->number}.pdf");
    }

    public function show($invoiceId)
    {
        // Charger la facture avec ses relations
        $invoice = Invoice::with('customer', 'work')->findOrFail($invoiceId);

        // Vérifier que la facture et le travail sont correctement liés
        $work = $invoice->work;
        if (!$work) {
            return redirect()->back()->with('error', 'Work not found for this invoice.');
        }

        $customer = $invoice->customer;
        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found for this invoice.');
        }

        try {
            // Générer le PDF
            Pdf::setOptions(['isRemoteEnabled' => true]); // Autoriser les images distantes
            $pdf = Pdf::loadView('invoices.template', compact('work', 'customer', 'invoice'));

            // Télécharger le PDF
            return $pdf->download("{$invoice->number}.pdf");
        } catch (\Exception $e) {
            // Gestion des erreurs
            return redirect()->back()->with('error', 'An error occurred while generating the PDF. Please try again.');
        }
    }


    public function markAsPaid($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        $invoice->update(['status' => 'paid']);

        return redirect()->back()->with('success', 'Invoice marked as paid.');
    }

    private function calculateTotal($work)
    {
        $baseCost = $work->base_cost;
        $productCost = $work->products->sum('price');
        $tps = round(($baseCost + $productCost) * 0.05, 2);
        $tvq = round(($baseCost + $productCost) * 0.09975, 2);

        return $baseCost + $productCost + $tps + $tvq;
    }
}
