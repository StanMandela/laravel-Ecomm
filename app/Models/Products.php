<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Products extends Model
{
    use HasFactory;
    use HasSlug;
    use  SoftDeletes;

    protected $fillable = ['title', 'description', 'price', 'image', 'image_mime', 'image_size', 'created_by', 'updated_by'];

   

     public function getSlugOptions(): SlugOptions
     {

      return SlugOptions::create()
         ->generateSlugsFrom('title')
         ->saveSlugsTo('slug');
     }
     public function getRouteKey()
     {
        return 'slug';
     }
     
}

