<?php

namespace App\Admin\Controllers;

use App\Models\News;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class NewsController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Новости');
            $content->description('список');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Новости');
            $content->description('редактировать');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('Новости');
            $content->description('создать');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(News::class, function (Grid $grid) {

            $grid->disableFilter();
            $grid->disableExport();
            $grid->id('ID')->sortable();

            $grid->category_id('Категория')->display(function ($id) {
                return \App\Models\NewsCategories::find($id)->title;
            })->sortable();

            $grid->title('Заголовок')->sortable();


            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'Enabled', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Disabled', 'color' => 'default'],
            ])->sortable();

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(News::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->select('category_id', 'Категория')->options(\App\Models\NewsCategories::where('active', 1)->get()->pluck('title', 'id'));
            $form->text('title', 'Заголовок');
            $form->text('slug', 'Подпись');

            $form->ckeditor('content', 'Контент');

            $form->switch('active')->states([
                'on'  => ['value' => 1, 'text' => 'Enable', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'Disable', 'color' => 'danger'],
            ])->default(1);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');

            $form->saving(function (Form $form){
                $title = $form->title;
                $slug = $form->slug;
                if(!is_null($form->title) && !empty($title)){
                    if(empty($slug) && !empty($title)) $form->slug = str_slug($title);
                }
            });
        });
    }
}
