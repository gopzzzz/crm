<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerSupport;
use Illuminate\Support\Facades\DB;

class CustomerSupportController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $customer_supports = DB::table('customer_supports')
    ->leftJoin('customers', 'customer_supports.customer_name', '=', 'customers.id')
    ->leftJoin('tbl_employees', 'customer_supports.assigned_employee', '=', 'tbl_employees.id')
    ->select(
        'customer_supports.*',
        'customers.name as customer_name_display',
        'tbl_employees.name as employee_name'
    )
    ->get();
        $customers = DB::table('customers')->get();
        $employees = DB::table('tbl_employees')->get();

        return view('admin.customer_support', compact('customer_supports', 'role','customers','employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|integer',
            'issue' => 'required|string|max:255',
            'ticket' => 'required|string|max:255',
            'assigned_employee' => 'nullable|integer',
            'status' => 'required|in:0,1,2',
            
            
        ]);

        CustomerSupport::create([
            'customer_name' => $request->customer_name,
            'issue' => $request->issue,
            'ticket' => $request->ticket,
            'status' =>$request->status,
            'assigned_employee' => $request->assigned_employee,
            
            ]);
        return redirect()->back()->with('success', 'Customer support added successfully!');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:customer_supports,id',
            'customer_name' => 'required|integer',
            'issue' => 'required|string|max:255',
            'ticket' => 'required|string|max:255',
            'assigned_employee' => 'nullable|integer',
            'status' => 'required|in:0,1,2',
        ]);

        $support = CustomerSupport::findOrFail($request->id);

        $data = [
            'issue' => $request->issue,
            'ticket' => $request->ticket,
            'assigned_employee' => $request->assigned_employee,
            'status' => $request->status,
            ];

if ($request->filled('customer_name')) {
    $data['customer_name'] = $request->customer_name;
}

$support->update($data);

        return redirect()->back()->with('success', 'Customer support updated successfully!');
    }
}