<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Category extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'name'
    ];
    protected $hidden = [
        'deleted_at'
    ];

    public function post(){
        return $this->hasMany(Product::class);
    }
}
