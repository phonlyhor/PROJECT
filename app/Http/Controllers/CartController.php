<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    
    public function view()
    {
        $cart = CartItem::where('user_id', Auth::id())->get();
        return view('seller.cart', compact('cart'));
    }
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cartItem = CartItem::where('user_id', Auth::id())
                              ->where('product_id', $id)
                              ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'name' => $product->ProductName,
                'price' => $product->Price,
                'quantity' => 1,
                'image' => $product->ProductImage,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    
    public function remove($id)
    {
        $cartItem = CartItem::where('user_id', Auth::id())
                              ->where('product_id', $id)
                              ->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }
}