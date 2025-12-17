<?php

namespace App\Http\Services;

use App\Http\Repositories\CategoryRepository;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public $categoryRepo;
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function createCategory(array $data)
    {
        DB::beginTransaction();
        try{
            $categoryExist = $this->categoryRepo->getByName($data['name']);
//            dd($categoryExist);
            if($categoryExist)
            {
                throw new \Exception('Category already exist!!');
            }

            $category = $this->categoryRepo->create($data);
            if(!$category)
            {
                throw new \Exception('Category not created!!');
            }
            DB::commit();
            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getAllCategory(){
        return $this->categoryRepo->getAll();
    }

    public function getCategoryById($id)
    {
        return $this->categoryRepo->find($id);
    }


    public function updateCategory($id, array $data)
    {
        DB::beginTransaction();
        try
        {
            $category = $this->categoryRepo->find($id);
            if(!$category){
                throw new \Exception('Category not found!!!!!!');
            }

            $updateCategory = $this->categoryRepo->update($id,$data);
            if(!$updateCategory){
                throw new \Exception('Category update failed!!');
            }
            DB::commit();
            return $this->getCategoryById($id);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteCategory($id)
    {
        DB::beginTransaction();
        try
        {
            $category = $this->categoryRepo->find($id);
            if(!$category){
                throw new \Exception('Category does not exists!!');
            }
            $this->categoryRepo->delete($id);
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
