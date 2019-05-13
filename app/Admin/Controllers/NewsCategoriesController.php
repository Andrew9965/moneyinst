<?php

namespace App\Admin\Controllers;

use App\Models\NewsCategories;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class NewsCategoriesController extends Controller
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

            $content->header('Категории новостей');
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

            $content->header('Категории новостей');
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

            $content->header('Категории новостей');
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
        return Admin::grid(NewsCategories::class, function (Grid $grid) {


            $grid->disableExport();
            $grid->disableFilter();
            $grid->id('ID')->sortable();

            $grid->slug('Подпись');
            $grid->title('Название');

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
        return Admin::form(NewsCategories::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title', 'Название');
            $form->text('slug', 'Подпись');

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

















