<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'subtotal' => $details['quantity'] * $product->current_price
                ];
                $subtotal += $details['quantity'] * $product->current_price;
            }
        }

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $taxAmount = $subtotal * 0.1; // 10% tax
        $shippingAmount = 50000; // 50,000 VND shipping
        $total = $subtotal + $taxAmount + $shippingAmount;

        return view('orders.checkout', compact('cartItems', 'subtotal', 'taxAmount', 'shippingAmount', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'payment_method' => 'required|string|in:cash_on_delivery,bank_transfer',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = 0;
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                if ($product) {
                    $subtotal += $details['quantity'] * $product->current_price;
                }
            }

            $taxAmount = $subtotal * 0.1;
            $shippingAmount = 50000;
            $total = $subtotal + $taxAmount + $shippingAmount;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'shipping_address' => [
                    'name' => $request->shipping_name,
                    'phone' => $request->shipping_phone,
                    'address' => $request->shipping_address,
                    'city' => $request->shipping_city,
                ],
                'billing_address' => [
                    'name' => $request->shipping_name,
                    'phone' => $request->shipping_phone,
                    'address' => $request->shipping_address,
                    'city' => $request->shipping_city,
                ],
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                if ($product) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $details['quantity'],
                        'unit_price' => $product->current_price,
                        'total_price' => $details['quantity'] * $product->current_price,
                    ]);

                    // Update stock
                    $product->decrement('stock_quantity', $details['quantity']);
                }
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Đơn hàng đã được đặt thành công!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi đặt hàng!');
        }
    }

    public function show($id)
    {
        $order = Order::with(['orderItems.product', 'user'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['orderItems.product'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }
}
