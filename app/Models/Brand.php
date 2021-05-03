<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    //relation one to more

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    //relation more a more

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
