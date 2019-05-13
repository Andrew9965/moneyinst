<?php

namespace App\Admin\Controllers;

use App\Models\Messages;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;
use Encore\Admin\Layout\Column;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Form as jForm;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class MessagesController extends Controller
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

            if(request()->type == 'inbox') {
                $title = "Входящие ";
            }else if(request()->type == 'outbox') {
                $title = "Исходящие ";
            }else if(request()->type == 'no_read') {
                $title = "Неотвеченные ";
            }else{
                $title = "Все ";
            }

            $content->header($title.'сообщения');
            $content->description('список');

            $content->body($this->grid($content));
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

            $content->header('Сообщения');
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
    protected function grid($content)
    {
        $table = Admin::grid(Messages::class, function (Grid $grid) {
            $grid->model()->orderBy('created_at', 'desc');

            if(request()->type == 'inbox') {
                $grid->model()->where('recipient_id','0');
            }else if(request()->type == 'outbox') {
                $grid->model()->where('sender_id',\Auth::user()->id);
            }else if(request()->type == 'no_read') {
                $grid->model()->where('read_at',null)->where('recipient_id','0');
            }

            $grid->id('ID')->sortable();
            $grid->disableExport();
            $grid->disableCreation();
            $grid->disableCreateButton();

            $users = collect(\App\User::all());
            $grid->sender_id('Отправитель')->display(function ($id) use ($users) {
                $users_data = $users->where('id', $id)->first();
                return $users_data->name. ' '.$users_data->last_name;
            })->sortable();

            $grid->subject('Тема');
            $grid->message('Сообщение');
            $grid->read_at('Прочитано');
            $grid->created_at();
            $grid->updated_at();

            $grid->filter(function($filter){
                $filter->equal('user_id', 'Отправитель')->select(\App\User::all()->pluck('username', 'id'));
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableEdit();
                if(request()->type == 'no_read'){
                    $actions->append('<a href="'.route('messages.index', array_merge(request()->all(), ['enter_message' => $actions->getKey()])).'"><i class="fa fa-envelope"></i> Ответить</a>');
                }
            });
        });

        $content->row(function(Row $row) use ($table) {
            $messages = collect(Messages::all());
            $row->column(2, function (Column $column) use ($messages) {
                $in = $messages->where('recipient_id','0')->all();
                $out = $messages->where('sender_id',\Auth::user()->id)->all();
                $no_readed = $messages->where('read_at',null)->where('recipient_id','0')->all();
                $column->row(new InfoBox('Входящие', 'inbox', 'aqua', '/admin/messages?type=inbox', count($in)));
                $column->row(new InfoBox('Исходящие', 'inbox', 'blue', '/admin/messages?type=outbox', count($out)));
                $column->row(new InfoBox('Неотвеченные', 'eye-slash', 'red', '/admin/messages?type=no_read', count($no_readed)));
            });
            $row->column(10, function (Column $column) use ($table, $messages) {
                if(request()->enter_message && $mess = $messages->where('read_at',null)->where('id', request()->enter_message)->first()){
                    $column->row($this->recipient_form($mess));
                }else
                    $column->row($table->render());
            });
        });

        //dd($table->render());
    }

    private function recipient_form(Messages $messages){
        //dd($messages);

        $form = new jForm();
        $form->action(route('enter_to_message', ['messages' => $messages->id]));
        $form->hidden('_token')->default(csrf_token());
        $form->display('sender.name', 'Получатель')->default($messages->sender->name);
        $form->text('subject', 'Тема')->default('Re: '.$messages->subject);
        $form->display('', 'Сообщение')->default($messages->message);
        $form->textarea('message', 'Ответ');

        $box = new Box('Ответ на сообщение "'.$messages->sender->name.': '.$messages->subject.'"', $form->render());
        $box->style('info');
        return $box;
    }

    public function enter_to_message(Messages $messages, Request $request){
        Messages::create(array_merge([
            'sender_id' => \Auth::user()->id,
            'recipient_id' => $messages->sender_id,
        ], $request->all()));
        $messages->read_at = now();
        $messages->save();
        $success = new MessageBag([
            'title'   => 'Ответ на сообщение',
            'message' => 'Ваше сообщение успешно отправлено пользователю: '.$messages->sender->name,
        ]);
        return redirect('/admin/messages?type=no_read')->with(compact('success'));
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Messages::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
