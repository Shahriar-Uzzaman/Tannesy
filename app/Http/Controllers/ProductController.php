<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getAll(){
        return $this->productService->findAll();
    }

    public function getByUser($userId)
    {
        return $this->productService->findByUser($userId);
    }

    public function getByCategory($categoryId){
        return $this->productService->findByCategory($categoryId);

    }

    public function create(ProductRequest $request)
    {
        return $this->productService->create($request->validated());
    }

    public function update($id, ProductUpdateRequest $request){
//        dd($request);
        return $this->productService->update($id, $request->validated());
    }

    public function delete($id){
        return $this->productService->delete($id);
    }
}
