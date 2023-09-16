<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'mobile_number' => 'required|unique:customers,mobile_number,' . $customer->id,
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone_number' => 'required',
            'image' => 'nullable|image',
            'active' => 'required|boolean',


        ]);

        $imagePath = "";

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Customer::create([
            "name" => $validatedData["name"],
            "mobile_number" => $validatedData["mobile_number"],
            "email" => $validatedData["email"],
            "phone_number" => $validatedData["phone_number"],
            "image" => $imagePath,
            'active' => $validatedData['active'],

        ]);


        return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        //   return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'mobile_number' => 'required|unique:customers,mobile_number,' . $customer->id,
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone_number' => 'required',
            'image' => 'nullable|image',
            'active' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($customer->image) {
                Storage::delete($customer->image);
            }

            $imagePath = $request->file('image')->store('images', 'public');
            $customer->image = $imagePath;
        }

        $customer->name = $validatedData["name"];
        $customer->mobile_number = $validatedData["mobile_number"];
        $customer->email = $validatedData["email"];
        $customer->phone_number = $validatedData["phone_number"];
        $customer->active = $validatedData["active"];

        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }



    public function toggleStatus(Customer $customer)
    {
        $customer->update(['active' => !$customer->active]);

        return redirect()->back()->with('success', 'Customer status toggled successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if ($customer->image) {
            Storage::delete($customer->image);
        }

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
