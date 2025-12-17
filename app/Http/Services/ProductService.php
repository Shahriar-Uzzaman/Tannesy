<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public $productRepo;
    public $imageUploadService;

    public function __construct(ProductRepository $productRepo, ImageUploadService $imageUploadService){
        $this->productRepo = $productRepo;
        $this->imageUploadService = $imageUploadService;
    }

    public function findAll() {
        return $this->productRepo->findAll();
    }

    public function findByCategory($categoryId) {
        return $this->productRepo->findByCategory($categoryId);
    }

    public function findByUser($userId) {
        $posts = $this->productRepo->findByUser($userId);
        return $posts;
    }

    public function create(array $data) {
        DB::beginTransaction();
        try{
            $userId = Auth::id();
            if (!isset($userId)) {
                throw new \Exception("User not found!!");
            }

            $data['user_id'] = $userId;
            $post = $this->productRepo->create($data);
            if (!$post){
                throw new \Exception("Failed to create post!!");
            }

            if (!empty($data['images'])) {
                $imagePath = 'products/' . $post->id;
                foreach ($data['images'] as $image) {
                    $this->imageUploadService->upload($image, $imagePath, $post);
                }
            }

            DB::commit();
            return $post;
        } catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function update($id ,array $data){
        DB::beginTransaction();
        try {

            $userId = Auth::id();
            if (!isset($userId)){
                throw new \Exception("User not found!!");       // is it needed??
            }

            $post = $this->productRepo->findById($id);
            if(!$post){
                throw new \Exception("Post not found!!");
            }

            if($post->user_id !== $userId){
                throw new \Exception("User cannot update this post!!");
            }

            $post = $this->productRepo->update($id, $data);
            if(!$post){
                throw new \Exception("Post update Failed!!");
            }

            DB::commit();
            return $this->productRepo->findById($id);

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id){
        DB::beginTransaction();
        try {
            $userId = Auth::id();
            $posts = $this->productRepo->findById($id);
            if(!$posts){
                throw new \Exception("Post not found!!");
            }

            if($posts->user_id !== $userId){
                throw new \Exception("User cannot delete this post!!");
            }

            $this->productRepo->destroy($id);
            DB::commit();
            return true;
        } catch (\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

}
