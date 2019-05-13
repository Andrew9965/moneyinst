<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ststistic extends Model
{
    protected $table = 'statistic';

    protected $fillable = ['user_id','site_id','date','cnt_lg','cnt_lg_u','cnt_lo','cnt_lo_u','installs','uinstalls','income'];
}
