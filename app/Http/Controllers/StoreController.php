<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
        return response()->json(Store::all());
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'address' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    $store = Store::create($request->only('name', 'address', 'latitude', 'longitude'));

    return response()->json(['message' => 'Mağaza oluşturuldu.', 'store' => $store], 201);
}

    public function show($id)
    {
        $store = Store::find($id);

        if (!$store) {
            return response()->json(['message' => 'Mağaza bulunamadı.'], 404);
        }

        return response()->json($store);
    }

    public function nearby(Request $request)
{
    $request->validate([
        'lat' => 'required|numeric',
        'lng' => 'required|numeric',
    ]);

    $lat = $request->lat;
    $lng = $request->lng;

    $stores = Store::selectRaw("
        *,
        (6371 * acos(
            cos(radians($lat)) * cos(radians(latitude))
            * cos(radians(longitude) - radians($lng))
            + sin(radians($lat)) * sin(radians(latitude))
        )) AS distance
    ")
    ->having('distance', '<=', 5)
    ->orderBy('distance')
    ->get();

    return response()->json($stores);
}
}