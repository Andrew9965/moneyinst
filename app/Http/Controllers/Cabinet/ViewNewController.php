<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\NewsCategories;
use Illuminate\Http\Request;
use App\Models\News;

class ViewNewController extends Controller
{
    public function index(NewsCategories $category, News $new, Request $request)
    {


        return view('view_new', ['new' => $new, 'category' => $category]);
    }
}
