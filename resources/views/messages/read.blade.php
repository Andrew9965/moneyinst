@extends('layouts.cabinet')

@section('title', '| Просмотр сообщений')

@section('content')
    <div class="cnt">
        <h1>Просмотр сообщений</h1>
        <div class="tbl-wrap tbl-fixed tbl-att-first tbl04">
            <table>
                <col class="col01">
                <col class="col02">
                <tbody>
                <tr>
                    <td>Тема</td>
                    <td class="subject">{{$message->subject}}</td>
                </tr>
                <tr>
                    <td>Отправитель</td>
                    <td>{{$message->recipient->username}}</td>
                </tr>
                <tr>
                    <td>Дата</td>
                    <td>{{$message->created_at}}</td>
                </tr>
                @if($message->sender_id==\Auth::user()->id)
                    <tr>
                        <td>Прочитано</td>
                        <td>{{$message->read_at ? $message->read_at : 'Нет'}}</td>
                    </tr>
                @endif
                <tr>
                    <td>Получатель</td>
                    <td>{{$message->sender->username}}</td>
                </tr>
                <tr>
                    <td>Сообщение</td>
                    <td>{{$message->message}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="tbl-actions">
            @if($message->sender_id!=\Auth::user()->id)
                <a href="{{route('cabinet.messages.write', ['id' => $message->id])}}">Ответить</a>
            @endif
            <a href="#deleteMessage:{{$message->id}}">Удалить</a>
            @push('scripts')
                <script>
                    $('[href^="#deleteMessage:"]').on('click', function(e){
                        var obj = $(this);
                        var $id = obj.attr('href').replace('#deleteMessage:','');
                        if(confirm('Удалить сообщение "'+$('.subject').html()+'"')){
                            $.delete('{{$message->sender_id==\Auth::user()->id ? route('cabinet.messages.outbox.delete') : route('cabinet.messages.inbox.delete')}}', {id: $id,'_token':$('[name="csrf-token"]').attr('content')}, function (result) {
                                if(result.status=='ok'){
                                    location = '{{$message->sender_id==\Auth::user()->id ? route('cabinet.messages.outbox') : route('cabinet.messages.inbox')}}';
                                }
                            });
                        }
                        return false;
                    });
                </script>
            @endpush
        </div>
    </div>
@endsection