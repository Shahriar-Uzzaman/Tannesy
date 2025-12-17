<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Image extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'path',
        'imageable_id',
        'imageable_type'
    ];
    
    protected $hidden = [
        'imageable_id',
        'imageable_type'
    ];
    
    public function imageable()
    {
        return $this->morphTo();
    }
}
