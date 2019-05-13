<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ScriptPages;

class ScriptsController extends Controller
{
    public function index(ScriptPages $scriptPages, Request $request)
    {
        return view('scripts', $scriptPages);
    }
}
