<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\Box;

class PageConditionsController extends Controller
{
    use ModelForm;

    public function index(Request $request)
    {
        return Admin::content(function (Content $content) {
            $content->header('Страница');
            $content->description('Условия');



            $form = new Form(\App\Models\InfoPages::where('page_slug', 'conditions')->first());
            $form->action(route('admin.scripts.save'));
            $form->hidden('page_slug')->default('conditions');
            $form->hidden('_token')->default(csrf_token());
            $form->ckeditor('description');

            $box = new Box('Контент страницы', $form->render());
            $content->body($box);
        });
    }
}
