<?php

namespace App\Admin\Controllers;

use App\Models\Scripts;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ScriptsController extends Controller
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

            $content->header('Файлы');
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

            $content->header('Файлы');
            $content->description('редактировать');

            $content->body($this->form($id)->edit($id));
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

            $content->header('Файлы');
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
        return Admin::grid(Scripts::class, function (Grid $grid) {
            $grid->disableExport();
            $grid->disableFilter();
            $grid->id('ID')->sortable();

            $grid->hash('Ссылка')->display(function ($file) {
                return $file;
            })->sortable();

            $grid->name('Имя');
            $grid->description('Описание');

            $grid->num_download('Кол-во загрузок')->sortable();

            $grid->active('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'Enabled', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Disabled', 'color' => 'default'],
            ])->sortable();

            $grid->created_at()->sortable();
            $grid->updated_at()->sortable();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=false)
    {
        return Admin::form(Scripts::class, function (Form $form) use ($id) {

            $form->display('id', 'ID');

            $form->file('file', 'Файл');

            $form->switch('active')->states([
                'on'  => ['value' => 1, 'text' => 'Enable', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'Disable', 'color' => 'danger'],
            ]);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');

            $form->saving(function (Form $form) use ($id){

            });
        });
    }
}
