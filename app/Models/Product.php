<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        "name",
        "description",
        "original_price",
        "current_price",
        "quantity",
        "user_id",
        "category_id",
    ];
    protected $hidden = [
        "user_id"
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
