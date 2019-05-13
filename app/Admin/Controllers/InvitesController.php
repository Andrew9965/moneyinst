<?php

namespace App\Admin\Controllers;

use App\Models\Invites;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\MessageBag;

class InvitesController extends Controller
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

            $content->header('Инвайты');
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

            $content->header('header');
            $content->description('description');

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

            $content->header('Инвайты');
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
        return Admin::grid(Invites::class, function (Grid $grid) {
            $grid->model()->orderBy('created_at', 'desc');
            $grid->disableExport();
            $grid->id('ID')->sortable();
            $grid->invite('Инвайт')->sortable();

            $users = collect(\App\User::all());
            $grid->admin_id('Создал')->display(function ($id) use ($users) {
                $users_data = $users->where('id', $id)->first();
                return '<a href="/admin/auth/users/'.$users_data->id.'/edit">'.$users_data->name. ' '.$users_data->last_name.'</a>';
            })->sortable();

            $grid->user_id('Применил')->display(function ($id) use ($users) {
                $users_data = $users->where('id', $id)->first();
                if($users_data) return '<a href="/admin/auth/users/'.$users_data->id.'/edit">'.$users_data->name. ' '.$users_data->last_name.'</a>';
                else return '---';
            })->sortable();

            $grid->registred_at('Дата применения')->sortable();
            $grid->created_at('Создано')->sortable();

            $grid->status('Статус')->display(function ($s) use ($users) {
                return $s ? "<label class='label label-success'>Открытый</label>" : "<label class='label label-danger'>Занят</label>";
            })->sortable();

            $grid->filter(function($filter){
                $filter->equal('invite', 'Инвайт');
                $filter->equal('admin_id', 'Создатель')->select(\App\User::all()->pluck('username', 'id'));
                $filter->like('registred_at', 'Дата применения')->date();
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableEdit();
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id=false)
    {
        if(!request()->invite){
            $invite = Invites::create([
                'invite' => md5(\Auth::user()->id.':'.now()),
                'admin_id' => \Auth::user()->id,
                'timestamp' => time()
            ]);

            $success = new MessageBag([
                'title'   => 'Успех',
                'message' => 'Инвайт успешно создан: '.$invite->invite,
            ]);
            return back()->with(compact('success'));
        }

        return Admin::form(Invites::class, function (Form $form) {

            $form->display('id', 'ID');

            //$form->select('admin_id', 'Создать от имени')->options(\App\User::where('is_admin',1)->get()->pluck('name', 'id'))->default(\Auth::user()->id);

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
