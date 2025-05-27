<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->orders()->with('items.product', 'table')->latest()->get();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'table_id' => 'required|exists:tables,id',
        ]);

        $cart = Cart::with('items.product')->where([
            'user_id' => $user->id,
            'table_id' => $request->table_id,
        ])->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Sepetiniz boş.'], 400);
        }

        $total = $cart->items->sum(fn($item) => $item->quantity * $item->product->price);

        $order = $user->orders()->create([
            'table_id' => $cart->table_id,
            'total_price' => $total,
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'menu_item_id' => $item->menu_item_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // sepet temizle
        $cart->items()->delete();

        $request->user()->increment('points', $total * 0.1);

        return response()->json(['message' => 'Sipariş oluşturuldu', 'order_id' => $order->id]);
    }

    public function show($id)
{
    $order = Order::with('items.product', 'table')->findOrFail($id);
    return response()->json($order);
}

public function cancel($id)
{
    $order = Order::findOrFail($id);

    if ($order->status !== 'pending') {
        return response()->json(['message' => 'Yalnızca bekleyen siparişler iptal edilebilir.'], 403);
    }

    $order->update(['status' => 'cancelled']);

    return response()->json(['message' => 'Sipariş iptal edildi.']);
}

public function status($id)
{
    $order = Order::findOrFail($id);
    return response()->json(['status' => $order->status]);
}

public function rate(Request $request, $id)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:500',
    ]);

    $order = Order::findOrFail($id);
    $order->update([
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return response()->json(['message' => 'Değerlendirme kaydedildi.']);
}
}
