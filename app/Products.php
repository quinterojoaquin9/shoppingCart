<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = ['title', 'description', 'imagePath', 'price', 'oldprice'];
}
