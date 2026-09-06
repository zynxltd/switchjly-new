<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompareController extends Controller
{
    public function details(Request $request): View
    {
        return view('compare.details', [
            'step' => 1,
            'postcode' => $request->session()->get('compare.postcode', $request->query('postcode', '')),
            'supplier' => $request->session()->get('compare.supplier', ''),
            'tariff' => $request->session()->get('compare.tariff', ''),
        ]);
    }

    public function storeDetails(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'postcode' => ['required', 'string', 'max:12'],
            'supplier' => ['required', 'string', 'max:100'],
            'tariff' => ['required', 'string', 'max:100'],
        ]);

        $request->session()->put('compare', array_merge(
            $request->session()->get('compare', []),
            $data,
        ));

        return redirect()->route('compare.usage');
    }

    public function usage(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('compare.postcode')) {
            return redirect()->route('compare.details');
        }

        return view('compare.usage', [
            'step' => 2,
            'usage' => $request->session()->get('compare.usage', '3100'),
            'fuel' => $request->session()->get('compare.fuel', 'dual'),
            'payment' => $request->session()->get('compare.payment', 'direct_debit'),
        ]);
    }

    public function storeUsage(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'usage' => ['required', 'string', 'max:20'],
            'fuel' => ['required', 'string', 'max:40'],
            'payment' => ['required', 'string', 'max:40'],
        ]);

        $request->session()->put('compare', array_merge(
            $request->session()->get('compare', []),
            $data,
        ));

        return redirect()->route('compare.deals');
    }

    public function deals(Request $request): View|RedirectResponse
    {
        $compare = $request->session()->get('compare');

        if (! $compare || empty($compare['postcode'])) {
            return redirect()->route('compare.details');
        }

        return view('compare.deals', [
            'step' => 3,
            'compare' => $compare,
            'dealCount' => 24,
            'savings' => 312,
        ]);
    }
}
