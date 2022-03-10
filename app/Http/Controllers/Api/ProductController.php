<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

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

        return response()->json([
            'response' => true,
            'count' => $product ? 1 : 0,
            'results' =>  [
                'data' => $product
            ],
        ]);
    }

    public function inRandomOrder()
    {
        $products = Product::inRandomOrder()->limit(4)->get();
        return response()->json([
            'response' => true,
            'results' =>  [
                'data' => $products
            ],
        ]);
    }

    public function search(Request $request)
    {
        $data = $request->all();


        //apriamo una chiamata eloquent senza chiuderla
        $products = Product::where('id', '>=', 1);

        //se abbiamo orderbycolumn e orderbysort in $data
        //li usiamo per ordinare
        if (
            array_key_exists('orderbycolumn', $data) &&
            array_key_exists('orderbysort', $data)
        ) {
            $products->orderBy($data['orderbycolumn'], $data['orderbysort']);
        }

        if (array_key_exists('tags', $data)) {
            foreach ($data['tags'] as $tag) {
                //fa una join per controllare i tag che sono associati al product
                $products->whereHas('tags', function (Builder $query) use ($tag) {
                    $query->where('name', '=', $tag);
                });
            }
        }

        $products = $products->with(['tags', 'category'])->get();

        return response()->json([
            'response' => true,
            'count' =>  $products->count(),
            'results' =>  [
                'data' => $products
            ],
        ]);
    }
}
