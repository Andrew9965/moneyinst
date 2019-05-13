<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsCategories;

class NewsController extends Controller
{
    public function index(NewsCategories $category, Request $request)
    {
        $news = \App\Models\News::where('active', 1)->with('category');
        if($category->slug) $news->where('category_id', $category->id);
        return view('news', ['news' => $news->paginate()]);
    }
}
