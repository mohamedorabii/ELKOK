<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingSetting;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function getActiveCartItems($userId)
    {
        return Cart::where('user_id', $userId)
            ->whereHas('product', function ($query) {
                $query->where('status', 1)
                    ->whereHas('category', function ($q) {
                        $q->where('status', 1);
                    });
            })
            ->with(['product', 'variant.color', 'variant.size'])
            ->get();
    }

    public function calculateTotals($cartItems)
    {
        $shipping = ShippingSetting::first()->price ?? 0;
        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->unit_price);
        $total    = $subtotal + $shipping;

        return compact('subtotal', 'shipping', 'total');
    }

   public function placeOrder($user, $data, $cartItems, $totals)
{
    $order = null;

    DB::transaction(function () use ($user, $data, $cartItems, $totals, &$order) {
        
        // تحقق من الكميات مع Lock
        foreach ($cartItems as $item) {
            $product = Product::lockForUpdate()->with('variants')->find($item->product_id);

            if (!$product) {
                throw new \Exception('Sorry, the selected product is no longer available.');
            }

            if ($item->variant_id) {
                $variant = $product->variants->firstWhere('id', $item->variant_id);

                if (!$variant || $variant->stock < $item->quantity) {
                    throw new \Exception(
                        "Sorry, only {$variant?->stock} units available for {$product->name_en}."
                    );
                }
            } elseif ($product->quantity < $item->quantity) {
                throw new \Exception(
                    "Sorry, only {$product->quantity} units available for {$product->name_en}."
                );
            }
        }

        $order = Order::create([
            'user_id'        => $user->id,
            'order_number'   => 'ORD-' . strtoupper(uniqid()),
            'status'         => 'pending',
            'shipping_price' => $totals['shipping'],
            'name'           => $data['name'],
            'phone'          => $data['phone'],
            'address'        => $data['address'],
            'city'           => $data['city'],
            'governorate'    => $data['governorate'],
            'total_price'    => $totals['total'],
        ]);

        foreach ($cartItems as $item) {
            $product = Product::lockForUpdate()->with('variants.color', 'variants.size')->find($item->product_id);
            $variant = $item->variant_id ? $product?->variants->firstWhere('id', $item->variant_id) : null;
            $unitPrice = $item->unit_price;

            OrderItem::create([
                'order_id'          => $order->id,
                'product_id'        => $item->product_id,
                'product_variant_id' => $variant?->id,
                'quantity'          => $item->quantity,
                'price'             => $unitPrice,
                'total_price'       => $item->quantity * $unitPrice,
                'color_name_en'     => $variant?->color?->name_en,
                'color_name_ar'     => $variant?->color?->name_ar,
                'size_name_en'      => $variant?->size?->name_en,
                'size_name_ar'      => $variant?->size?->name_ar,
                'variant_sku'       => $variant?->sku,
            ]);

            if ($variant) {
                $variant->decrement('stock', $item->quantity);
            } else {
                $product->decrement('quantity', $item->quantity);
            }
        }

        Cart::where('user_id', $user->id)->delete();
    });

    return $order;
}

    public function getUserOrders($userId)
    {
        return Order::where('user_id', $userId)
            ->with(['items.product', 'items.variant.color', 'items.variant.size'])
            ->latest()
            ->get();
    }

    public function cancelOrder(Order $order, int $userId): bool
    {
        if ($order->user_id !== $userId) {
            return false;
        }

        if ($order->status !== 'pending') {
            return false;
        }

        DB::transaction(function () use ($order) {
            $order->loadMissing('items.product', 'items.variant');

            foreach ($order->items as $item) {
                if ($item->variant) {
                    $item->variant->increment('stock', $item->quantity);
                } elseif ($item->product) {
                    $item->product->increment('quantity', $item->quantity);
                }
            }

            $order->update(['status' => 'cancelled']);
        });

        return true;
    }
}