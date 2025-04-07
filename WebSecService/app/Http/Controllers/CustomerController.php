<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index()
    {
        if (!Auth::user()->hasPermissionTo('manage_customers')) {
            abort(403);
        }

        $customers = User::role('Customer')->with('customer')->get();

        return view('customers.index', compact('customers'));
    }

    public function addCredit(Request $request, Customer $customer)
    {
        if (!Auth::user()->hasPermissionTo('add_credit')) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:10000',
        ]);

        $customer->credit += $request->amount;
        $customer->save();

        return redirect()->back()->with('success', 'Credit added successfully!');
    }
}
