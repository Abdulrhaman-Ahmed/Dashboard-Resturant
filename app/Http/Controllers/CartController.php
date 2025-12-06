<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Get session ID for guest users
     */
    private function getSessionId()
    {
        if (!session()->has('cart_session_id')) {
            session(['cart_session_id' => uniqid('cart_', true)]);
        }
        return session('cart_session_id');
    }

    /**
     * Get cart items for current user/session
     */
    private function getCartItems()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->with('meal')->get();
        } else {
            return Cart::where('session_id', $this->getSessionId())->with('meal')->get();
        }
    }

    /**
     * Display cart
     */
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $cartItems->sum('subtotal');

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request, $mealId)
    {
        $meal = Meal::findOrFail($mealId);

        $cartData = [
            'meal_id' => $meal->id,
            'price' => $meal->price,
        ];

        if (Auth::check()) {
            $cartData['user_id'] = Auth::id();
        } else {
            $cartData['session_id'] = $this->getSessionId();
        }

        // Check if item already exists in cart
        $cartItem = Cart::where('meal_id', $meal->id)
            ->where(function($query) use ($cartData) {
                if (isset($cartData['user_id'])) {
                    $query->where('user_id', $cartData['user_id']);
                } else {
                    $query->where('session_id', $cartData['session_id']);
                }
            })
            ->first();

        if ($cartItem) {
            // Update quantity
            $cartItem->increment('quantity');
        } else {
            // Create new cart item
            Cart::create(array_merge($cartData, ['quantity' => 1]));
        }

        return redirect()->back()->with('success', 'Meal added to cart successfully!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $cartId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        $cartItem = Cart::findOrFail($cartId);

        // Verify ownership
        if (Auth::check() && $cartItem->user_id != Auth::id()) {
            abort(403);
        }

        if (!Auth::check() && $cartItem->session_id != $this->getSessionId()) {
            abort(403);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart
     */
    public function remove($cartId)
    {
        $cartItem = Cart::findOrFail($cartId);

        // Verify ownership
        if (Auth::check() && $cartItem->user_id != Auth::id()) {
            abort(403);
        }

        if (!Auth::check() && $cartItem->session_id != $this->getSessionId()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            Cart::where('session_id', $this->getSessionId())->delete();
        }

        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }

    /**
     * Get cart count for navbar
     */
    public function count()
    {
        $count = $this->getCartItems()->sum('quantity');
        return response()->json(['count' => $count]);
    }
}
