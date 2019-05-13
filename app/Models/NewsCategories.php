<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategories extends Model
{
    protected $table = 'news_categories';

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
