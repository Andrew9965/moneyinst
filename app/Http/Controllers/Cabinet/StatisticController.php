<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sites;
use App\Models\Ststistic;

class StatisticController extends Controller
{
    public function index(Sites $site, Request $request)
    {
        $date_from = date('d.m.Y');
        $date_to = date('d.m.Y');

        if($request->date_from && $request->date_to && count(explode('.',$date_from))==3 && count(explode('.',$date_to))==3){
            $date_from = $request->date_from;
            $date_to = $request->date_to;
        }

        if($request->sort && count($sort = explode('-', $request->sort))==2){
            $ofield = $sort[0]; $omethod = $sort[1];
            if($omethod!='desc' && $omethod!='asc') $omethod = 'desc';
            if($ofield!='date' && $ofield!='cnt_lg' && $ofield!='cnt_lg_u' && $ofield!='cnt_lo' && $ofield!='cnt_lo_u' && $ofield!='installs' && $ofield!='uinstalls' && $ofield!='income') $ofield='date';
        }else{
            $ofield = 'date';
            $omethod = 'desc';
        }

        $statistic = Ststistic::where('user_id', \Auth::user()->id)->orderby($ofield, $omethod);
        $statistic->where('date', '>=', $date_from)->where('date', '<=', $date_to);

        if(isset($site->id)) $statistic->where('site_id', $site->id);

        $statistic = $statistic->get();

        $stats = [];

        foreach ($statistic as $stat){
            $stats[$stat->date] = [
                'cnt_lg' => $stat['cnt_lg']+(isset($stats[$stat->date]['cnt_lg']) ? $stats[$stat->date]['cnt_lg'] : 0),
                'cnt_lg_u' => $stat['cnt_lg_u']+(isset($stats[$stat->date]['cnt_lg_u']) ? $stats[$stat->date]['cnt_lg_u'] : 0),
                'cnt_lo' => $stat['cnt_lo']+(isset($stats[$stat->date]['cnt_lo']) ? $stats[$stat->date]['cnt_lo'] : 0),
                'cnt_lo_u' => $stat['cnt_lo_u']+(isset($stats[$stat->date]['cnt_lo_u']) ? $stats[$stat->date]['cnt_lo_u'] : 0),
                'installs' => $stat['installs']+(isset($stats[$stat->date]['installs']) ? $stats[$stat->date]['installs'] : 0),
                'uinstalls' => $stat['uinstalls']+(isset($stats[$stat->date]['uinstalls']) ? $stats[$stat->date]['uinstalls'] : 0),
                'income' => $stat['income']+(isset($stats[$stat->date]['income']) ? $stats[$stat->date]['income'] : 0),
            ];
        }

        //dd($stats);

        return view('statistic', [
            'site' => $site,
            'stats' => $stats,
            'statistic' => $statistic,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'mySites' => collect(Sites::allMySites()),
            'ofield' => $ofield,
            'omethod' => $omethod
        ]);
    }
}
