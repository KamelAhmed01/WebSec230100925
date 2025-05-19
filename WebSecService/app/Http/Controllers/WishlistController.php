<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->hasPermissionTo('manage_wishlist')) {
            abort(403);
        }

        $wishlist = $request->user()->wishlist()->get();
        return view('wishlist.index', compact('wishlist'));
    }

    public function store(Request $request, Product $product)
    {
        if (!$request->user()->hasPermissionTo('manage_wishlist')) {
            abort(403);
        }
        $request->user()->wishlist()->syncWithoutDetaching([$product->id]);
        return back()->with('success', 'Added to wishlist!');
    }

    public function destroy(Request $request, Product $product)
    {
        if (!$request->user()->hasPermissionTo('manage_wishlist')) {
            abort(403);
        }
        $request->user()->wishlist()->detach($product->id);
        return back()->with('success', 'Removed from wishlist.');
    }
}
