<?php

namespace App\Admin\Controllers;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Permission;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\User;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Form as DForm;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\MessageBag;
use App\ApiService;

class UserController extends Controller
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
            $content->header(trans('admin.administrator'));
            $content->description(trans('admin.list'));
            $content->body($this->grid()->render());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header(trans('admin.administrator'));
            $content->description(trans('admin.edit'));
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
            $content->header(trans('admin.administrator'));
            $content->description(trans('admin.create'));
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
        return Administrator::grid(function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->username(trans('admin.username'));
            $grid->name(trans('admin.name'));
            $grid->roles(trans('admin.roles'))->pluck('name')->label();
            $grid->created_at(trans('admin.created_at'));
            $grid->updated_at(trans('admin.updated_at'));

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->getKey() == 1) {
                    $actions->disableDelete();
                }
                $actions->append('<a href="'.route('users_balance', ['user' => $actions->getKey()]).'"><i class="fa fa-money"></i></a>');
            });

            $grid->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                    $actions->disableDelete();
                });
            });

        });
    }

    public function users_balance(User $user, Request $request)
    {
        return Admin::content(function (Content $content) use ($user, $request) {
            $content->header('Пополнение баланса пользователю');
            $content->description($user->name.' '.$user->last_name);

            $content->row(function(Row $row) use ($user) {
                $row->column(6, (new Box('Баланс', $this->user_balance_form($user)))->style('primary') );
                $row->column(6, (new Box('История', $this->user_balance_history($user)))->style('info'));
            });
        });
    }

    public function users_balance_post(User $user, Request $request)
    {
        \App\Models\Balance::create(array_merge([
            'user_id' => $user->id
        ], $request->all()));
        $user->balance += $request->amount;
        $user->save();
        $success = new MessageBag([
            'title'   => 'Успех',
            'message' => "Баланс пользователя \"{$user->name}\" успешно пополнен!",
        ]);
        return redirect('/admin/auth/users')->with(compact('success'));
    }

    private function user_balance_form(User $user){
        $form = new DForm();

        $form->action(route('users_balance_post', ['user' => $user->id]))->attribute(['data-api-form' => 'true']);


        $form->currency('amount', 'Сумма к списанию')->symbol('₽')->rules('required');

        $form->dateRange('date_from', 'date_to', 'Период');

        $form->html(csrf_field());

        $last = \App\Models\Balance::where('user_id', $user->id)->select('date_to')->orderby('created_at', 'desc')->first();
        $date_to = $last ? explode(' ', $last->date_to)[0] : explode(' ', $user->created_at)[0];

        Admin::script("initBalance({$user->id},'{$date_to}');");

        return $form->render();
    }

    public function get_statistic(User $user, Request $request)
    {
        $statistic = (new ApiService())->overall_stats(false, $user->id);
        if($statistic['error']) return response($statistic);
        $chart_data = isset($statistic['result'][0]) ? $statistic['result'] : [0 => $statistic['result']];
        $amount = 0;
        foreach ($chart_data as $data){
            $amount += $data['income'];
        }
        return response(['error' => false, 'result' => $amount]);
    }

    private function user_balance_history(User $user){
        $headers = ['Id', 'Date from', 'Date to', 'Amount'];
        $rows = \App\Models\Balance::where('user_id', $user->id)->select('id','date_from','date_to','amount')->get()->toArray();


        $table = new Table($headers, $rows);

        return $table->render();
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form($id=false)
    {
        return Administrator::form(function (Form $form) use ($id) {
            if($id) $form->setAction(route('users.update', ['user' => $id]));
            $form->display('id', 'ID');

            $form->text('username', 'Логин')->rules('required');
            $form->text('name', trans('admin.name'))->rules('required');
            $form->text('last_name', 'Фамилия');

            $form->image('avatar', trans('admin.avatar'));
            $form->password('password', trans('admin.password'))->rules('required|confirmed');
            $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });

            $form->ignore(['password_confirmation']);

            $form->text('skype', 'Skype');
            $form->text('icq', 'ICQ');
            $form->text('telegram', 'Телеграмм');

            $form->display('balance', 'Баланс');
            $form->text('wmr', 'WMR');

            $form->multipleSelect('roles', trans('admin.roles'))->options(Role::all()->pluck('name', 'id'));
            $form->multipleSelect('permissions', trans('admin.permissions'))->options(Permission::all()->pluck('name', 'id'));

            $form->switch('is_admin', 'Доступ к админ панеле')->states([
                'on'  => ['value' => 1, 'text' => 'Да', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'Нет', 'color' => 'danger'],
            ])->default(1);

            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
            });
            //$form->disablePjax();
        });
    }
}
