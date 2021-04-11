<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function create($inputs)
    {
        return Product::create($inputs);
    }
}
