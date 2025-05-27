<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuCategory;
use App\Models\MenuItem;

class MenuController extends Controller
{
    public function allMenu(Request $request)
    {
        return MenuItem::with('category')
            ->when($request->store_id, fn($q) => $q->where('store_id', $request->store_id))
            ->get();
    }

    public function categories(Request $request)
    {
        return MenuCategory::when($request->store_id, function ($query) use ($request) {
            $query->whereIn('id', MenuItem::where('store_id', $request->store_id)
                ->pluck('category_id')
                ->unique());
        })->get();
    }

    public function byCategory(Request $request, $id)
    {
        return MenuItem::with('category')
            ->where('category_id', $id)
            ->when($request->store_id, fn($q) => $q->where('store_id', $request->store_id))
            ->get();
    }

    public function itemDetail($id)
    {
        $item = MenuItem::with('category')->find($id);

        return $item
            ? response()->json($item)
            : response()->json(['message' => 'Ürün bulunamadı.'], 404);
    }

    public function popular(Request $request)
    {
        return MenuItem::with('category')
            ->where('is_popular', true)
            ->when($request->store_id, fn($q) => $q->where('store_id', $request->store_id))
            ->get();
    }

    public function search(Request $request)
    {
        $q = $request->query('query');

        if (!$q) {
            return response()->json(['message' => 'Arama kelimesi gerekli.'], 400);
        }

        return MenuItem::with('category')
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                      ->orWhere('description', 'like', "%$q%");
            })
            ->when($request->store_id, fn($q) => $q->where('store_id', $request->store_id))
            ->get();
    }
}