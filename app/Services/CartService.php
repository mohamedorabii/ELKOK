<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ShippingSetting;

class CartService
{

    public function getIdentifier($userId = null, $sessionId = null): array
    {
        return $userId
            ? ['user_id' => $userId]
            : ['session_id' => $sessionId];
    }


    public function getCartItems(array $identifier)
    {
        return Cart::where($identifier)
            ->whereHas('product', function ($query) {
                $query->where('status', 1)
                    ->whereHas('category', function ($q) {
                        $q->where('status', 1);
                    });
                })
                ->with(['product', 'variant.color', 'variant.size'])
            ->get();
    }


   public function calculateTotal($cartItems): array
{
    $shipping = ShippingSetting::first()->price ?? 0;

    $total = $cartItems->sum(function ($item) {
        if (!$item->product) {
            return 0;
        }

        return $item->unit_price * $item->quantity;
    });

    return compact('total', 'shipping');
}

   public function addToCart(array $identifier, int $productId, int $quantity = 1, ?int $variantId = null): bool
{
    $product = Product::where('status', 1)
        ->with(['variants'])
        ->whereHas('category', fn($q) => $q->where('status', 1))
        ->find($productId);

    if (!$product) {
        return false;
    }

    $variant = null;

    if ($product->has_variants) {
        if (!$variantId) {
            return false;
        }

        $variant = $product->variants->firstWhere('id', $variantId);

        if (!$variant || $variant->stock < $quantity) {
            return false;
        }
    }

    if (!$product->has_variants && $quantity > $product->quantity) {
        return false;
    }

    $cartItem = Cart::where($identifier)
        ->where('product_id', $productId)
        ->where('variant_id', $variantId)
        ->first();

    $newQuantity = ($cartItem?->quantity ?? 0) + $quantity;

    // لا تسمح بإضافة كمية أكبر من المخزون
    if ($product->has_variants) {
        if ($newQuantity > $variant->stock) {
            return false;
        }
    } elseif ($newQuantity > $product->quantity) {
        return false;
    }

    if ($cartItem) {
        $cartItem->update([
            'quantity' => $newQuantity,
        ]);
    } else {
        Cart::create([
            ...$identifier,
            'product_id' => $productId,
            'variant_id' => $variantId,
            'quantity'   => $quantity,
        ]);
    }

    return true;
}

   public function updateCart(Cart $cart, int $quantity, ?int $userId): bool
{
    $cart->loadMissing(['product.variants', 'variant']);

    // Guest cart
    if ($userId === null) {
        if ($quantity > $cart->available_stock) {
            return false;
        }
        $cart->update(['quantity' => $quantity]);
        return true;
    }

    // User cart
    if ($cart->user_id !== $userId) {
        return false;
    }

    if (!$cart->product || $quantity > $cart->available_stock) {
        return false;
    }

    $cart->update(['quantity' => $quantity]);
    return true;
}

public function removeFromCart(Cart $cart, ?int $userId): bool
{
    // Guest cart
    if ($userId === null) {
        $cart->delete();
        return true;
    }

    // User cart
    if ($cart->user_id !== $userId) {
        return false;
    }

    $cart->delete();
    return true;
}
    public function clearCart(array $identifier): void
    {
        Cart::where($identifier)->delete();
    }
}
