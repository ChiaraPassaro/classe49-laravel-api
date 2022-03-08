<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(8);

        return response()->json([
            'response' => true,
            'results' =>  $products,
        ]);
    }

    public function show($id) 
    {
        $product = Product::find($id);
        if (empty($product)) {
            $product = [];
        }
        return response()->json([
            'response' => true,
            'results' =>  $product,
        ]);
    }

    public function orderBy(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        $products = Product::orderBy($data['orderby'], $data['order'])->get();

        return response()->json([
            'response' => true,
            'results' =>  $products,
        ]);

    }
}
