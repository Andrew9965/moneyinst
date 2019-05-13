<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScriptPages extends Model
{
    protected $table = 'script_pages';

    public function getRouteKeyName()
    {
        return 'uri';
    }
}
