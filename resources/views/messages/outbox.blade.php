@extends('layouts.cabinet')

@section('title', '| Отправленные')

@section('content')
    <div class="cnt">
        <h1>Отправленные</h1>

        <div class="tbl-wrap tbl-att tbl-hover tbl-fixed tbl03">
            <table>
                <col class="col04">
                {{--<col class="col01">--}}
                <col class="col02">
                <col class="col03">
                <col class="col03">
                <col class="col04">
                <thead>
                <tr>
                    <th>ID</th>
                    {{--<th>Получатель</th>--}}
                    <th>Тема</th>
                    <th>Отправлено</th>
                    <th>Прочитано</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach($messages = \App\Models\Messages::outBox() as $message)
                <tr href="{{route('cabinet.messages.read', ['id' => $message->id])}}">
                    <td>{{$message->id}}</td>
                    {{--<td>{{  $message->recipient->username }}</td>--}}
                    <td class="subject">{{$message->subject}}</td>
                    <td>{{$message->created_at}}</td>
                    <td>{{$message->read_at ? $message->read_at : 'Нет'}}</td>
                    <td><a href="#deleteMessage:{{$message->id}}" class="tbl-button">удалить</a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if(!count($messages))
            <center><h1>Пусто</h1></center>
        @endif

        @push('scripts')
            <script>
                $('tr[href]').on('click', function(e){
                    e.preventDefault();
                    location = $(this).attr('href');
                });

                $('[href^="#deleteMessage:"]').on('click', function(e){
                    var obj = $(this);
                    var $id = obj.attr('href').replace('#deleteMessage:','');
                    if(confirm('Удалить сообщение "'+obj.parents('tr[href]').find('.subject').html()+'"')){
                        $.delete('{{route('cabinet.messages.outbox.delete')}}', {id: $id,'_token':$('[name="csrf-token"]').attr('content')}, function (result) {
                            if(result.status=='ok'){
                                obj.parents('tr[href]').hide('slow', function(){ $(this).remove(); });
                            }
                        });
                    }
                    return false;
                }).parent().on('click', function(){ return false; });
            </script>
        @endpush
        <!-- pagenav box -->
        {{ $messages->links() }}
        <!-- /pagenav box -->
    </div>
@endsection