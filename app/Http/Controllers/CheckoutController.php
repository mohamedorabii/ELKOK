<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceOrderRequest;
use App\Models\Order;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct(protected CheckoutService $checkoutService) {}

    public function index()
    {
        $cartItems = $this->checkoutService->getActiveCartItems(Auth::id());

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $totals = $this->checkoutService->calculateTotals($cartItems);

        return view('checkout', array_merge(compact('cartItems'), $totals));
    }

    public function placeOrder(PlaceOrderRequest $request)
    {
        try {
            $user      = Auth::user();
            $cartItems = $this->checkoutService->getActiveCartItems($user->id);

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
            }

            $totals = $this->checkoutService->calculateTotals($cartItems);
            $order  = $this->checkoutService->placeOrder($user, $request->validated(), $cartItems, $totals);

            return redirect()->route('checkout.confirmation', $order);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function confirmation(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout-confirmation', compact('order'));
    }

    public function myOrders()
    {
        $orders = $this->checkoutService->getUserOrders(Auth::id());
        return view('orders', compact('orders'));
    }

    public function cancelOrder(Order $order)
    {
        $cancelled = $this->checkoutService->cancelOrder($order, auth()->id());

        if (! $cancelled) {
            return back()->with(
                'error',
                'You cannot cancel this order.'
            );
        }

        return back()->with(
            'success',
            'Order cancelled successfully.'
        );
    }
}
