<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = "balance";

    protected $fillable = ["user_id","date_from","date_to","amount"];

    public function scopeMyBalance($query)
    {
        return $query->where('user_id', \Auth::user()->id)->orderby('created_at', 'desc')->paginate();
    }
}
