<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Model\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'vegetables',
            'fruits',
            'meat',
            'breakfast',
            'beverages',
            'frozen',
            'candies'
        ];

        foreach ($categories as $category) {
            $newCategory = new Category();
            $newCategory->name = $category;
            $newCategory->slug = Str::slug($category, '-');
            $newCategory->save();
        }
    }
}
