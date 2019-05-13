<?php

namespace App\Admin\Controllers;

use App\Models\Payments;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class PaymentsController extends Controller
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

            $content->header('Выплаты');
            $content->description('список');

            $content->body($this->grid());
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

            $content->header('Выплаты');
            $content->description('создать выплату');

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
        return Admin::grid(Payments::class, function (Grid $grid) {
            $grid->model()->orderBy('created_at', 'desc');
            $grid->id('ID')->sortable();

            $users = collect(\App\User::all());
            $grid->user_id('Пользователь')->display(function ($id) use ($users) {
                $users_data = $users->where('id', $id)->first();
                return '<a href="/admin/auth/users/'.$users_data->id.'/edit">'.$users_data->name. ' '.$users_data->last_name.'</a>';
            })->sortable();

            $grid->date_from('С')->sortable();
            $grid->date_to('По')->sortable();

            //$grid->amount('Сумма')->sortable();

            $grid->amount('Сумма')->display(function ($sum) {
                return number_format($sum, 2, ',', ' ').' ₽';
            })->sortable();

            $grid->note('Примечание')->sortable();
            $grid->wallet_number('Номер кошелька')->sortable();

            $grid->created_at('Дата')->sortable();

            $grid->actions(function ($actions) {
                $actions->disableEdit();
            });

            $grid->filter(function($filter){
                $filter->disableIdFilter();

                $filter->equal('user_id', 'Пользователь')->select(\App\User::all()->pluck('username', 'id'));
                $filter->equal('amount')->currency();

                $filter->like('date_from', 'Дата с')->date();
                $filter->like('date_to', 'Дата по')->date();
                $filter->like('created_at', 'Дата выплаты')->date();

                //$filter->like('name', 'name');
            });
        });
    }

    public function get_wallet(Request $request){
//        /dd($request);
        return \App\User::find($request->q)->wmr;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Payments::class, function (Form $form) {

            $user = \App\User::find(request()->user);

            $form->display('id', 'ID');

            $form->select('user_id', 'Пользователь')
                ->options(\App\User::all()->pluck('username', 'id'))
                ->rules('required')
                ->default(request()->user)
                ->attribute(['onchange' => 'location = "/admin/payments/create?user="+$(this).val()']);

            //->ajax('/admin/payments/wallet', 'wallet_number');

            $form->date('date_from', 'С')->rules('required');
            $form->date('date_to', 'По')->rules('required');

            $form->currency('amount', 'Сумма к списанию')->symbol('₽')->rules('required')->default(isset($user->balance) ? $user->balance : '');


            $form->text('wallet_number', 'Номер кошелька')->default(isset($user->wmr) ? $user->wmr : '');
            $form->textarea('note', 'Примечание');


            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');

            $form->saving(function ($form) {

                $user = \App\User::find($form->user_id);

                $new_balance = $user->balance - $form->amount;
                if($new_balance<0){
                    $error = new MessageBag([
                        'title'   => 'Ошибка',
                        'message' => 'У пользователя не достаточно средств на балансе',
                    ]);
                    return back()->with(compact('error'));
                }else{
                    $user->balance = $new_balance;
                    $user->save();
                }
            });
        });
    }
}
