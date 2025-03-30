<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\User;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function addCredit(Request $request, User $user)
    {
        // Check if the user has permission to manage credits
        if (!$request->user()->hasPermissionTo('manage_credits')) {
            abort(401);
        }

        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01']
        ]);

        // Get or create credit record for the user
        $credit = Credit::firstOrCreate(
            ['user_id' => $user->id],
            ['amount' => 0]
        );

        // Add the amount
        $credit->amount += $request->amount;
        $credit->save();

        return redirect()->back()->with('success', "Added {$request->amount} credit to {$user->username}'s account");
    }
}
