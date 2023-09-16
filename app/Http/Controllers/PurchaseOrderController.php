<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrderItem;
use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Currency;


use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::all();
        $purchaseOrderItems = PurchaseOrderItem::all();


        return view('purchase-orders.index', compact('purchaseOrders', 'purchaseOrderItems'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $customers = Customer::all();
        $currencies = Currency::all();

        return view('purchase-orders.create', compact('currencies', 'customers', 'products'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PurchaseOrderItem $purchaseOrder)
    {
        // dd($request);

        $validatedData = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'date' => 'required|date',
            'product_id.*' => 'nullable|exists:products,id',
            'price.*' => 'required',
            'currency_id.*' => 'nullable|exists:currencies,id',
            'quantity.*' => 'required',
            'total_amount.*' => 'required',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'customer_id' => $validatedData['customer_id'],
            'date' => $validatedData['date'],
        ]);

        foreach ($validatedData['product_id'] as $index => $productId) {
            PurchaseOrderItem::create([
                'purchase_order_id' => $purchaseOrder->id,
                'product_id' => $productId,
                'price' => $validatedData['price'][$index],
                'currency_id' => $validatedData['currency_id'][$index],
                'quantity' => $validatedData['quantity'][$index],
                'total_amount' => $validatedData['total_amount'][$index],
            ]);
        }

        // dd($validatedData);


        return redirect()->route('purchase-orders.index')
            ->with('success', 'Order added successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //  $purchaseOrder = PurchaseOrder::findOrFail($id);
        //return view('purchase-orders.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $customers = Customer::all();
        $products = Product::all();
        $purchaseOrderItems = PurchaseOrderItem::where('purchase_order_id', $id)->get();

        return view('purchase-orders.edit', compact('purchaseOrder', 'customers', 'products', 'purchaseOrderItems'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'date' => 'required|date',
            'product_id.*' => 'nullable|exists:products,id',
            'price.*' => 'required',
            'currency_id.*' => 'nullable|exists:currencies,id',
            'quantity.*' => 'required',
            'total_amount.*' => 'required',
        ]);

        $purchaseOrder = PurchaseOrder::findOrFail($id);

        $purchaseOrder->update([
            'customer_id' => $validatedData['customer_id'],
            'date' => $validatedData['date'],
        ]);

        $purchaseOrder->items()->delete();

        foreach ($validatedData['product_id'] as $index => $productId) {
            $purchaseOrder->items()->create([
                'product_id' => $productId,
                'price' => $validatedData['price'][$index],
                'currency_id' => $validatedData['currency_id'][$index],
                'quantity' => $validatedData['quantity'][$index],
                'total_amount' => $validatedData['total_amount'][$index],
            ]);
        }

        return redirect()->route('purchase-orders.index')
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);


        $purchaseOrder->delete();

        return redirect()->route('purchase-orders.index')
            ->with('success', 'Purchase order deleted successfully.');
    }
}
