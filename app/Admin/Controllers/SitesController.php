<?php

namespace App\Admin\Controllers;

use App\Models\Sites;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class SitesController extends Controller
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

            $content->header('Сайты');
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

            $content->header('Сайты');
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

            $content->header('header');
            $content->description('description');

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
        return Admin::grid(Sites::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->disableExport();
            $grid->disableCreation();

            $users = collect(\App\User::all());
            $grid->user_id('Владелец')->display(function ($id) use ($users) {
                $users_data = $users->where('id', $id)->first();
                return '<a href="/admin/auth/users/'.$users_data->id.'/edit">'.$users_data->name. ' '.$users_data->last_name.'</a>';
            })->sortable();

            $grid->name();
            $grid->site();

            $grid->status('Status')->switch([
                'on'  => ['value' => 1, 'text' => 'Одобрен', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Не одобрен', 'color' => 'default'],
            ])->sortable();

            $grid->filter(function($filter){
                $filter->equal('user_id', 'Пользователь')->select(\App\User::all()->pluck('username', 'id'));

                $filter->like('name', 'Name');
                $filter->like('site', 'Url');

                $filter->equal('status', 'Статус')->select(['1' => 'Одобренные', '0' => 'Не одобренные']);
            });

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
        return Admin::form(Sites::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('name');
            $form->url('site');

            $form->switch('status')->states([
                'on'  => ['value' => 1, 'text' => 'Одобрен', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => 'Не одобрен', 'color' => 'default'],
            ])->default(1);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
