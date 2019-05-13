@extends('layouts.cabinet')

@section('title', '| Сайты')

@section('content')
    <div class="cnt">
        <a href="{{route('cabinet.sites.new')}}" class="btn btn-vsmall btn-title">Добавить сайт</a>
        <h1>Сайты</h1>
        <div class="tbl-wrap tbl-att tbl-fixed tbl07">
            <table>
                <col class="col01">
                <col class="col02">
                <col class="col03">
                <col class="col04">
                <col class="col05">
                <thead>
                <tr>
                    <th class="th-sortable">
                        <div class="th-title">ID</div>
                        <a href="" class="btn-action-sort down"></a>
                    </th>
                    <th class="th-sortable">
                        <div class="th-title">Дата заведения</div>
                        <a href="" class="btn-action-sort down"></a>
                    </th>
                    <th class="th-sortable">
                        <div class="th-title">Состояние</div>
                        <a href="" class="btn-action-sort down"></a>
                    </th>
                    <th class="th-sortable">
                        <div class="th-title">URL</div>
                        <a href="" class="btn-action-sort down"></a>
                    </th>
                    <th>Ссылки</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sites as $site)
                <tr>
                    <td>{{$site->id}}</td>
                    <td>{{$site->created_at}}</td>
                    <td>{{$site->status ? 'Одобренный' : 'Ожидает одобрения'}}</td>
                    <td><noindex><a href="{{$site->site}}" target="_blank">{{$site->site}}</a></noindex></td>
                    <td>
                        <div class="tbl-buttons">
                            {{--<a href="" class="btn btn-border">СПИСОК ФАЙЛОВ</a>
                            <a href="" class="btn btn-border">СОЗДАТЬ ССЫЛКУ</a>--}}
                            <a href="{{route('cabinet.statistic', ['site' => $site->id])}}" class="btn btn-border">СТАТИСТИКА</a>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if(!count($sites))
            <center><h1>Пусто</h1></center>
        @endif
        <!-- pagenav box -->
        {{ $sites->links() }}
        <!-- /pagenav box -->
    </div>
@endsection
