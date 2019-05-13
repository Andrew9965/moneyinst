<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Messages;

class MessagesController extends Controller
{
    public function writeIndex($re_id=false)
    {
        $data = [];

        if($re_id){
            $re_message = Messages::find($re_id);
            if($re_message) $data['re_message'] = $re_message;
        }

        return view('messages.write', $data);
    }

    public function readIndex($id)
    {
        $message = Messages::findMy($id);
        if(!$message) abort(404);
        if($message->sender_id!=\Auth::user()->id)
            $message->readIt($id);

        return view('messages.read', ['message'=>$message]);
    }

    public function inboxIndex(Request $request)
    {

        return view('messages.inbox');
    }

    public function outboxIndex(Request $request)
    {

        return view('messages.outbox');
    }

    public function outboxDelete(Request $request)
    {
        if(is_null($request->id) || !is_numeric($request->id) || !$message = Messages::where('sender_id', \Auth::user()->id)->where('id', $request->id)->first())
            return response(['status' => 'error']);
        else{
            $message->delete();
            return response(['status' => 'ok']);
        }
    }

    public function inboxDelete(Request $request)
    {
        if(is_null($request->id) || !is_numeric($request->id) || !$message = Messages::where('recipient_id', \Auth::user()->id)->where('id', $request->id)->first())
            return response(['status' => 'error']);
        else{
            $message->delete();
            return response(['status' => 'ok']);
        }
    }

    public function writePost(Request $request)
    {
        $errorMessages = [
            //'recipient.required' => 'Необходимо ввести имя получателя.',
            //'recipient.max' => 'Максимальное кол-во символов в имени получателя 255.',
            'subject.required' => 'Необходимо ввести тему сообщения.',
            'subject.max' => 'Максимальное кол-во символов в теме сообщения 255.',
            'message.required' => 'Необходимо ввести сообщение.',
            'message.min' => 'Минимальное кол-во символов в сообщении 50.',
        ];

        $this->validate($request, [
            //'recipient' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:5'
        ], $errorMessages);

        //$recipient = \App\User::findByLogin($request->recipient)->where('id', '!=', \Auth::user()->id)->first();

        /*if(!$recipient){
            return redirect()->route('cabinet.messages.write')->withInput()->withErrors(['Получатель не найден!']);
        }*/

        Messages::create(array_merge([
            'sender_id' => \Auth::user()->id
        ], $request->all()));

        return redirect()->route('cabinet.messages.outbox')->with(['status' => 'Ваше сообщение отправлено!']);
    }
}


























