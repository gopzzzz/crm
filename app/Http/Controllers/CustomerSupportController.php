<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerSupport;

class CustomerSupportController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $customer_supports = CustomerSupport::orderBy('id', 'desc')->get();

        return view('admin.customer_support', compact('customer_supports', 'role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'issue' => 'required|string|max:255',
            
        ]);

        CustomerSupport::create([
            'customer_name' => $request->customer_name,
            'issue' => $request->issue,
        ]);

        return redirect()->back()->with('success', 'Customer support added successfully!');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:customer_supports,id',
            'customer_name' => 'required|string|max:255',
            'issue' => 'required|string|max:255',
            'status' => 'required|in:0,1,2',
        ]);

        $support = CustomerSupport::findOrFail($request->id);

        $support->update([
            'customer_name' => $request->customer_name,
            'issue' => $request->issue,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Customer support updated successfully!');
    }
}