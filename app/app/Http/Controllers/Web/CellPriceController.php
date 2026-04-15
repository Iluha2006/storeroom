<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\WarehouseCell;
use Illuminate\Http\Request;

class CellPriceController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $cell = WarehouseCell::with('object')->where('slug', $slug)->firstOrFail();
        $tariffs = $cell->getTariffs();

        foreach ($tariffs as &$t) {
            $t['total'] = round($t['price'] * $t['months'], 2);
        }
        return response()->json([
            'success' => true,
            'tariffs' => $tariffs,

        ]);
    }
}