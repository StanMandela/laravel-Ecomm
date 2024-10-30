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

     protected $fillable =[
      'title',
        'description',
        'slug',
        'price',
        'slug'
     ];

     public function user(){
      return $this->belongsTo(User::class);
     }

     public function getSlugOptions(): SlugOptions
     {

      return SlugOptions::create()
         ->generateSlugsFrom('title')
         ->saveSlugsTo('slug');
     }
     
}

