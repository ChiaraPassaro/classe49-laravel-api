<?php

namespace App\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image'
    ];

    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Model\Tag');
    }

    public function createSlug($title)
    {
        $slug = Str::slug($title, '-');

        $oldProduct = Product::where('slug', $slug)->first();

        $counter = 0;
        while ($oldProduct) {
            $newSlug = $slug . '-' . $counter;
            $oldProduct = Product::where('slug', $newSlug)->first();
            $counter++;
        }

        return (empty($newSlug)) ? $slug : $newSlug;
    }
}
