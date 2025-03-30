<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\PurchaseItem;
use App\Models\Credit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->hasPermissionTo('view_purchases')) {
            abort(401);
        }

        $purchases = $request->user()->purchases()->with('purchaseItems.product')->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function store(Request $request, $productId)
    {
        if (!$request->user()->hasPermissionTo('make_purchases')) {
            abort(401);
        }

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1']
        ]);

        $product = Product::findOrFail($productId);
        $quantity = $request->input('quantity');
        $totalCost = $product->price * $quantity;

        // Get user credit
        $credit = Credit::firstOrCreate(
            ['user_id' => $request->user()->id],
            ['amount' => 0]
        );

        // Credit check
        if ($credit->amount < $totalCost) {
            $shortfall = $totalCost - $credit->amount;

            return redirect()->back()->with([
                'error' => 'You do not have enough credit for this purchase.',
                'insufficientCredit' => true,
                'requiredAmount' => $totalCost,
                'shortfall' => $shortfall
            ]);
        }

        // Calculate total price
        $totalPrice = $product->price * $request->quantity;

        // Check if user has enough credit
        if ($credit->amount < $totalPrice) {
            return redirect()->back()->with('error', 'Insufficient credit to complete this purchase.');
        }

        // Start transaction to ensure all operations succeed or fail together
        DB::beginTransaction();

        try {
            // Create purchase
            $purchase = Purchase::create([
                'user_id' => $request->user()->id,
                'total_amount' => $totalPrice
            ]);

            // Create purchase item
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]);

            // Update product stock
            $product->stock -= $request->quantity;
            $product->save();

            // Deduct from user credit
            $credit->amount -= $totalPrice;
            $credit->save();

            DB::commit();

            return redirect()->route('purchases.index')->with('success', 'Purchase completed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
