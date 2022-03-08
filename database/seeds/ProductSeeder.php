<?php

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Model\Category;
use App\Model\Product;
use App\Model\Tag;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 30; $i++) {
            $newProduct = new Product();
            $newProduct->category_id = Category::inRandomOrder()->first()->id;
            $newProduct->name = $faker->words(3, true);
            $newProduct->slug = $newProduct->createSlug($newProduct->name);
            $newProduct->description = $faker->sentences(2, true);
            $newProduct->image = 'uploads/products/default.png';
            $newProduct->price = $faker->randomFloat(1, 20, 30);
            $newProduct->save();
            $randLimit = rand(1, 7);
            $tags = Tag::inRandomOrder()->limit($randLimit)->get();

            $newProduct->tags()->attach($tags);
        }
    }
}
