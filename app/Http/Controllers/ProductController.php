<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }


    public function create()
    {
        return view('product.create');
    }

    public function store(ProductCreateRequest $request)
    {
        $inputs = $request->validated();

        $product = $this->productService->create($inputs);

        return back()->with('product', $product);
    }
}
