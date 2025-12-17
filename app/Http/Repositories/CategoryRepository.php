<?php

namespace App\Http\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function create($data)
    {
        return Category::create($data);
    }

    public function getAll()
    {
        return Category::all();
    }

    public function find($id)
    {
        return Category::where('id', $id)->first();
    }

    public function getByName($name)
    {
        return Category::where('name', $name)->first();
    }


    public function update($id, $data)
    {
        return Category::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Category::where('id', $id)->delete();
    }
}
