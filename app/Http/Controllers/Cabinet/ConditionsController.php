<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConditionsController extends Controller
{
    public function index(Request $request)
    {
        $page = \App\Models\InfoPages::where('page_slug', 'conditions')->first();
        return view('conditions', $page->toArray());
    }
}
