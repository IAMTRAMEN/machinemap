<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::with('machine')->latest()->get();
        return view('admin.quotes.index', compact('quotes'));
    }

    // ADD THIS MISSING METHOD
    public function show(Quote $quote)
    {
        $quote->load(['machine', 'components.category']);
        
        $componentsPrice = $quote->components->sum('pivot.unit_price');
        $pricing = [
            'base_price' => $quote->machine->base_price,
            'components_price' => $componentsPrice,
            'total' => $quote->total_price,
            'installation_time' => $quote->total_installation_time
        ];

        return view('admin.quotes.show', compact('quote', 'pricing'));
    }

    public function updateStatus(Request $request, Quote $quote)
    {
        $request->validate([
            'status' => 'required|in:draft,sent,accepted,rejected'
        ]);

        $quote->update(['status' => $request->status]);

        return redirect()->route('admin.quotes.show', $quote)
                         ->with('success', 'Quote status updated successfully.');
    }

    public function exportPdf(Quote $quote)
    {
        $quote->load(['machine', 'components.category']);
        
        $componentsPrice = $quote->components->sum('pivot.unit_price');
        $pricing = [
            'base_price' => $quote->machine->base_price,
            'components_price' => $componentsPrice,
            'total' => $quote->total_price,
            'installation_time' => $quote->total_installation_time
        ];

        $pdf = Pdf::loadView('configurator.pdf', compact('quote', 'pricing'))
                 ->setPaper('a4')
                 ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download("quote_{$quote->quote_number}.pdf");
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();
        return redirect()->route('admin.quotes.index')
                         ->with('success', 'Quote deleted successfully.');
    }
}