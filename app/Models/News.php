<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public function category()
    {
        return $this->hasOne('App\Models\NewsCategories', 'id', 'category_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
