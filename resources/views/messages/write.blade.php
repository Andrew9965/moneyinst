@extends('layouts.cabinet')

@section('title', '| Новое сообщение')

@section('content')
    <div class="cnt">
        <div class="main-title">Новое сообщение</div>
        <form action="{{route('cabinet.messages.writePost')}}" method="post">
            {{csrf_field()}}
            <!-- row -->
            @if(isset($re_message))
                <input type="hidden" name="re_id" value="{{$re_message->id}}">
            @endif
            <div class="frm-row">
                {{--<div class="frm-field half">
                    <label>Получатель</label>
                    <input type="text" name="recipient" value="{{old('recipient', (isset($re_message) ? $re_message->sender->username : ''))}}">
                </div>--}}
                <div class="frm-field">
                    <label>Тема</label>
                    <input type="text" name="subject" value="{{ !is_null(old('subject')) ? old('subject') : (isset($re_message) ? 'Re: '.$re_message->subject : '') }}">
                </div>
            </div>
            <!-- /row -->
            <!-- row -->
            <div class="frm-row">
                <div class="frm-field">
                    <label>Сообщение</label>
                    <textarea name="message">{{old('message')}}</textarea>
                </div>
            </div>
            <!-- /row -->
            <!-- row -->
            <div class="frm-row-submit">
                <input type="submit" value="Отправить">
            </div>
            <!-- /row -->
        </form>
    </div>
@endsection