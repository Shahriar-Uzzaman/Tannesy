<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create(CategoryRequest $request)
    {
        return$this->categoryService->createCategory($request->validated());
    }

    public function findAll()
    {
        return $this->categoryService->getAllCategory();
    }

    public function getOne($id)
    {
        return $this->categoryService->getCategoryById($id);
    }

    public function update($id, CategoryRequest $request)
    {
        return $this->categoryService->updateCategory($id, $request->validated());
    }

    public function delete($id)
    {
        return $this->categoryService->deleteCategory($id);
    }
}
