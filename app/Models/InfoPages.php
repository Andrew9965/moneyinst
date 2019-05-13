<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoPages extends Model
{
    protected $table = 'info_pages';

    protected $fillable = ['page_slug', 'description'];
}
