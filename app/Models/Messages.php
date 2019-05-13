<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{

    protected $fillable = ['sender_id', 'recipient_id', 'subject', 'message', 'read_at'];

    public function scopeGetCount($guery)
    {
        $count = $guery->where('recipient_id', \Auth::user()->id)->where('read_at', null)->count();
        if($count) return "({$count})";
        else return "";
    }

    public function scopeReadIt($query, $id)
    {
        return $query->find($id)->update(['read_at' => now()]);
    }

    public function scopeFindMy($query, $id)
    {
        $result = $query->where('id', $id)->where(function($query) {
            $query->where('sender_id', \Auth::user()->id)->orWhere('recipient_id', \Auth::user()->id);
        })->first();

            //->orWhere('sender_id', \Auth::user()->id)->orWhere('recipient_id', \Auth::user()->id)->first();
        if($result) return $result;
        else return false;
    }

    public function scopeOutBox($query)
    {
            return $query->where('sender_id', \Auth::user()->id)->with('recipient')->orderby('created_at', 'desc')->paginate();
    }

    public function scopeInBox($query)
    {
        return $query->where('recipient_id', \Auth::user()->id)->with('recipient')->orderby('created_at', 'desc')->paginate();
    }

    public function sender()
    {
        return $this->hasOne('App\User', 'id', 'sender_id');
    }

    public function recipient()
    {
        return $this->hasOne('App\User', 'id', 'recipient_id');
    }
}
