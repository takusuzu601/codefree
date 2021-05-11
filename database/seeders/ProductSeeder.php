<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(250)->create()->each(function (Product $product) {
            Image::factory(4)->create([
                "imageable_id" => $product->id,
                "imageable_type" => Product::class
            ]);
        });
    }
}
