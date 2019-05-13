<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invites extends Model
{
    protected $fillable = ['invite','admin_id','user_id','status','registred_at','timestamp'];
}
