<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;

class TableController extends Controller
{
    public function index(Request $request)
    {
        return Table::when($request->store_id, function ($query) use ($request) {
                $query->where('store_id', $request->store_id);
            })
            ->get();
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'name' => 'required|string',
            'qr_code' => 'required|string|unique:tables',
        ]);

        $table = Table::create($request->only('store_id', 'name', 'qr_code'));

        return response()->json(['message' => 'Masa oluşturuldu.', 'table' => $table], 201);
    }
    
    public function showByQr($qr_code)
    {
        $table = Table::where('qr_code', $qr_code)->first();

        if (!$table) {
            return response()->json(['message' => 'Masa bulunamadı.'], 404);
        }

        return response()->json($table);
    }
}