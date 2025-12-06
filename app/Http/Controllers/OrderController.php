<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Get session ID for guest users
     */
    private function getSessionId()
    {
        return session('cart_session_id', uniqid('cart_', true));
    }

    /**
     * Get cart items
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
     * Show checkout form
     */
    public function checkout()
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = $cartItems->sum('subtotal');

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    /**
     * Process order
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'notes' => 'nullable|string|max:500',
        ]);

        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = $cartItems->sum('subtotal');

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'total_amount' => $total,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'meal_id' => $item->meal_id,
                    'meal_name' => $item->meal->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);
            }

            // Clear cart
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            } else {
                Cart::where('session_id', $this->getSessionId())->delete();
            }

            DB::commit();

            return redirect()->route('orders.success', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Show order success page
     */
    public function success($orderId)
    {
        $order = Order::with('items.meal')->findOrFail($orderId);

        // Verify ownership for logged-in users
        if (Auth::check() && $order->user_id != Auth::id()) {
            abort(403);
        }

        return view('orders.success', compact('order'));
    }

    /**
     * Show user's orders
     */
    public function myOrders()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->get();

        return view('orders.my-orders', compact('orders'));
    }

    /**
     * Show single order details
     */
    public function show($orderId)
    {
        $order = Order::with('items.meal')->findOrFail($orderId);

        // Verify ownership
        if (Auth::check() && $order->user_id != Auth::id()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Admin: View all orders
     */
    public function adminIndex()
    {
        $orders = Order::with('user', 'items')->latest()->get();
        return view('orders.admin-index', compact('orders'));
    }

    /**
     * Admin: Update order status
     */
    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = Order::findOrFail($orderId);
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
    
    /**
     * Cancel order
     */
    public function cancel($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Verify ownership for logged-in users
        if (Auth::check() && $order->user_id != Auth::id()) {
            abort(403);
        }
        
        // Only allow cancellation of pending orders
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be cancelled!');
        }
        
        $order->update(['status' => 'cancelled']);
        
        return redirect()->route('orders.my')->with('success', 'Order cancelled successfully!');
    }
}
