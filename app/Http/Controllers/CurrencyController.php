<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::all();

        return view('currencies.index', compact('currencies'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Currency $currency)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'symbol' => 'required',
            'decimal_digits' => 'required|integer',
            'is_virtual' => 'required|boolean',
            'is_status' => 'required|boolean',

        ]);

        if ($request->is_virtual) {

            Currency::where('is_virtual', true)->update(['is_virtual' => false]);
        }

        Currency::create($validatedData);

        return redirect()->route('currencies.index')->with('success', 'Currency created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $currencies = Currency::findOrFail($id);

        return view('currencies.show', compact('currencies'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $currencies = Currency::findOrFail($id);

        return view('currencies.edit', compact('currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'symbol' => 'required',
            'decimal_digits' => 'required|integer',
            'is_virtual' => 'required|boolean',
            'is_status' => 'required|boolean',

        ]);

        if ($request->is_virtual) {
            Currency::where('is_virtual', true)->where('id', '!=', $currency->id)->update(['is_virtual' => false]);
        }

        $currency->update($request->only(['name', 'symbol', 'decimal_digits', 'is_virtual', 'is_status']));

        return redirect()->route('currencies.index')
            ->with('success', 'Currency updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();

        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully.');
    }
}
