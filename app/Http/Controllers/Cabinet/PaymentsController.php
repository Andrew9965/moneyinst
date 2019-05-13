<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    public function index(Request $request)
    {
        if($request->sort && count($sort = explode('-', $request->sort))==2){
            $ofield = $sort[0]; $omethod = $sort[1];
            if($omethod!='desc' && $omethod!='asc') $omethod = 'desc';
            if($ofield!='created_at' && $ofield!='date_from' && $ofield!='date_to' && $ofield!='amount') $ofield='created_at';
        }else{
            $ofield = 'created_at';
            $omethod = 'desc';
        }
        $payment = \App\Models\Payments::where('user_id', \Auth::user()->id)->orderby($ofield, $omethod)->paginate();

        return view('payments', ['payments' => $payment, 'ofield' => $ofield, 'omethod' => $omethod]);
    }
}
