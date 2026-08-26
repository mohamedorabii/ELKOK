<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService) {}

    private function identifier(): array
    {
        return $this->cartService->getIdentifier(
            Auth::check() ? Auth::id() : null,
            session()->getId()
        );
    }

    public function index()
    {
        $cartItems = $this->cartService->getCartItems($this->identifier());
        $totals    = $this->cartService->calculateTotal($cartItems);

        return view('cart', array_merge(compact('cartItems'), $totals));
    }

    public function addToCart(AddToCartRequest $request)
    {
        $added = $this->cartService->addToCart(
            $this->identifier(),
            $request->product_id,
            $request->quantity ?? 1,
            $request->variant_id
        );

        if (!$added) {
            return redirect()->back()->withErrors([
                'quantity' => 'The requested quantity exceeds the available stock.'
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart successfully ✅');
    }

    public function updateCart(UpdateCartRequest $request, Cart $cart)
    {
        $updated = $this->cartService->updateCart(
            $cart,
            $request->quantity,
            Auth::id(),
            session()->getId()
        );

        if (!$updated) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The requested quantity is not available.',
                ], 422);
            }

            return redirect()->back()->withErrors([
                'quantity' => 'The requested quantity is not available.'
            ]);
        }

        if ($request->expectsJson()) {
            $cart->refresh()->loadMissing(['product', 'variant']);

            $cartItems = $this->cartService->getCartItems($this->identifier());
            $totals    = $this->cartService->calculateTotal($cartItems);

            return response()->json([
                'success' => true,
                'item' => [
                    'id'              => $cart->id,
                    'quantity'        => $cart->quantity,
                    'unit_price'      => $cart->unit_price,
                    'line_total'      => $cart->unit_price * $cart->quantity,
                    'available_stock' => $cart->available_stock,
                ],
                'totals' => [
                    'total' => $totals['total'],
                ],
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Cart updated successfully ✅');
    }

    public function removeFromCart(Cart $cart)
    {
        $this->cartService->removeFromCart($cart, Auth::id());

        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully✅.');
    }

    public function clearCart()
    {
        $this->cartService->clearCart($this->identifier());

        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully✅.');
    }
}
