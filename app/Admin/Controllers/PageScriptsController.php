<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\Box;

class PageScriptsController extends Controller
{
    use ModelForm;

    public function index(Request $request)
    {
        return Admin::content(function (Content $content) {
            $content->header('Страница');
            $content->description('Скрипты для сайта');



            $form = new Form(\App\Models\InfoPages::where('page_slug', 'scripts')->first());
            $form->action(route('admin.scripts.save'));
            $form->hidden('page_slug')->default('scripts');
            $form->hidden('_token')->default(csrf_token());
            $form->ckeditor('description');

            $box = new Box('Контент страницы', $form->render());
            $content->body($box);
        });
    }

    public function save(Request $request)
    {
        $page = \App\Models\InfoPages::updateOrCreate(
            ['page_slug' => $request->page_slug],
            ['description' => $request->description]
        );

        return redirect()->back();
    }
}
