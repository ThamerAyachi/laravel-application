<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()->paginate(10, ['*'], 'p');
        return response()->json($products, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string',
            "stock" => 'required|integer',
            "size" => [Rule::in(Product::SIZES)],
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 422,
                "errors" => $validator->errors(),
            ], 422);
        }

        $product = ProductRepository::create($request->name, $request->stock, $request->size);
        // $product->user->products;

        return response()->json([
            "status" => 201,
            "product" => $product
        ], 201);

    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            "name" => 'required|string',
            "quantity" => 'required|integer',
            "size" => "required|in:small,medium,large"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 422,
                "errors" => $validator->errors(),
            ], 422);
        }

        $productRepository = new ProductRepository($product);
        $productRepository->update([
            "name" => $request->name,
            "quantity" => $request->stock,
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
