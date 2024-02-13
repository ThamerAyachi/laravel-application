<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{
    public function index($page = 1)
    {
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $products = Product::skip($offset)->take($perPage)->get();
        return response()->json([
            "status" => 200,
            "data" => $products
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string',
            "stock" => 'required|integer',
            "size" => "required|in:small,medium,large"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 422,
                "errors" => $validator->errors(),
            ], 422);
        }

        $product = Product::create([
            "name" => $request->name,
            "stock" => $request->stock,
            "size" => $request->size,
        ]);

        return response()->json([
            "status" => 201,
            "product" => $product
        ], 201);

    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(["message" => "Product not found"], 404);
        }

        $validator = Validator::make($request->all(), [
            "name" => 'required|string',
            "stock" => 'required|integer',
            "size" => "required|in:small,medium,large"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 422,
                "errors" => $validator->errors(),
            ], 422);
        }

        $product->update([
            "name" => $request->name,
            "stock" => $request->stock,
            "size" => $request->size,
        ]);

        return response()->json([
            "status" => 201,
            "product" => $product
        ], 201);

    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
