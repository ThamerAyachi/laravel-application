<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    /**
     * @var Product
     */
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public static function paginate($perPage = 10, $page = 1)
    {
        return Product::query()->isPublished()->whereHas('relation')->paginate($perPage, ['*'], 'p', $page);
    }

    /**
     * @param string $name
     * @param int $stock
     * @param int $size
     *
     * @return Product
     */
    public static function create($name, $stock, $size = Product::SIZE_SMALL)
    {
        $product = new Product();
        $product->name = $name;
        $product->stock = $stock;
        $product->size = 'small';
        $product->save();

        return $product;
    }

    public function update($attributes = [])
    {
        if (isset($attributes['name'])) {
            $this->product->name = $attributes['name'];
        }

        if (isset($attributes['quantity'])) {
            $this->product->stock = $attributes['quantity'];
        }

        if (isset($attributes['size'])) {
            $this->product->size = $attributes['size'];
        }
    }
}



