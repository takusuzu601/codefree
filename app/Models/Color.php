<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    //リレーション　多対多
    public function products()
    {
        return $this->belongsTomany(Product::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }
}
