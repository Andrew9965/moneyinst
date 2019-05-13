<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{

    protected $fillable = ['user_id', 'name', 'status', 'site'];

    public function scopeMySites($query)
    {
        return $query->where('user_id', \Auth::user()->id)->orderby('created_at', 'desc')->paginate();
    }

    public function scopeAllMySites($query)
    {
        return $query->where('user_id', \Auth::user()->id)->orderby('created_at', 'desc')->get();
    }

}
