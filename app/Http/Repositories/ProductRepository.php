<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function findAll()
    {
        return Product::with('category', 'user')->get();
    }

    public function findByCategory($categoryId)
    {
        return Product::with('category', 'user')->where('category_id', $categoryId)->get(); //
    }

    public function findByUser($userId)
    {
        return Product::with('category', 'user')->where('user_id', $userId)->get();
    }

    public function view($id)
    {
        return Product::with('category', 'user')->where('id', $id)->first();
    }

    public function findById($id)
    {
        return Product::where('id', $id)->first();
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {

        return Product::where('id', $id)->update($data);
    }

    public function destroy($id)
    {
        return Product::where('id', $id)->delete();
    }
}
