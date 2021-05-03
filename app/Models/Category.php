<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'icon'];

    //relation 1対多
    public function subcategories()
    {
        return $this->hasMany(Category::class);
    }

    //relation 多対多
    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    //hasManyThroughは飛び越えてリレーションを定義
    public function products()
    {
        return $this->hasManyThrough(Product::class, Subcategory::class);
    }
}
