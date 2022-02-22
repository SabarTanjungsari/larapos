<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use League\CommonMark\Inline\Element\Code;

class ApiProduct extends Controller
{
    public function getByCode($code)
    {
        $product = Product::where('code', $code)->get()->first();

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }
}
