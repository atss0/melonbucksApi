<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\MenuItem;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json(['message' => 'Giriş yapmanız gerekiyor.'], 401);
    }

    $tableId = $request->query('table_id');

    if (!$tableId) {
        return response()->json(['message' => 'table_id parametresi gereklidir.'], 422);
    }

    $cart = Cart::with(['items.product', 'table'])
        ->where('user_id', $user->id)
        ->where('table_id', $tableId)
        ->first();

    if (!$cart) {
        return response()->json(['message' => 'Bu kullanıcıya ve masaya ait sepet bulunamadı.'], 404);
    }

    return response()->json($cart);
}

    public function add(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'nullable|integer|min:1',
            'table_id' => 'required|exists:tables,id'
        ]);

        $cart = $this->getOrCreateCart($request);

        $item = $cart->items()->where('menu_item_id', $request->menu_item_id)->first();

        if ($item) {
            $item->increment('quantity', $request->quantity ?? 1);
        } else {
            $cart->items()->create([
                'menu_item_id' => $request->menu_item_id,
                'quantity' => $request->quantity ?? 1,
            ]);
        }

        return response()->json(['message' => 'Ürün sepete eklendi.']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
            'table_id' => 'required|exists:tables,id'
        ]);

        $cart = $this->getOrCreateCart($request);

        $item = $cart->items()->where('menu_item_id', $request->menu_item_id)->first();

        if (!$item) {
            return response()->json(['message' => 'Ürün sepette bulunamadı.'], 404);
        }

        $item->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Sepet güncellendi.']);
    }

    public function remove(Request $request, $id)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id'
        ]);

        $cart = $this->getOrCreateCart($request);
        $cart->items()->where('menu_item_id', $id)->delete();

        return response()->json(['message' => 'Ürün sepetten çıkarıldı.']);
    }

    public function clear(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id'
        ]);

        $cart = $this->getOrCreateCart($request);
        $cart->items()->delete();

        return response()->json(['message' => 'Sepet temizlendi.']);
    }

    private function getOrCreateCart(Request $request): Cart
    {
        $tableId = $request->input('table_id');

        if (!$request->user()) {
            abort(401, 'Giriş yapmanız gerekiyor.');
        }

        return Cart::firstOrCreate([
            'user_id' => $request->user()->id,
            'table_id' => $tableId,
        ]);
    }
}