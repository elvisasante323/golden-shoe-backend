<?php

namespace App\Http\Controllers;

use App\Models\Shoes;

class ShoesController extends Controller
{
    /**
     * @param Shoes $shoes
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Shoes $shoes)
    {
        $shoes = $shoes->where('quantity', '!=', 0)->get();

        return response()->json([
           'shoes' => $shoes
        ]);
    }
}
