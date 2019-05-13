@extends('layouts.cabinet')

@section('title', '| Статистика по всем сайтам')

@push('head_scripts')
{{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>--}}
<script src="{{asset('dateRangePicker/moment.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" href="{{asset('dateRangePicker/daterangepicker.min.css')}}" />
<script src="{{asset('dateRangePicker/jquery.daterangepicker.min.js')}}"></script>
@endpush

@section('content')

    <div class="cnt">
        <h1>Статистика</h1>
        <form action="{{route('cabinet.statistic', ['site' => request()->site])}}" class="filter-box" onsubmit="onSubmitDate($(this)); return false;">
            <div class="frm-row">
                <div class="frm-field half">
                    <div id="date-range12-container"></div>
                </div>
                <div class="frm-field half">
                    <select onchange="location=$(this).val();">
                        <option value="{{route('cabinet.statistic', array_merge(['site' => ''], request()->all()))}}">Все сайты</option>
                        @foreach($mySites as $sit)
                        <option value="{{route('cabinet.statistic', array_merge(['site' => $sit->id], request()->all()))}}" {{$sit->id==$site->id ? 'selected' : ''}}>{{$sit->site}}</option>
                        @endforeach
                    </select><br>
                    <input type="text" id="dateRangePicker">
                    <button type="submit">Пересчитать</button>
                </div>
            </div>
            <input type="hidden" name="date_from" value="{{request()->date_from && count(explode('.', request()->date_from))==3 ? request()->date_from : date('d.m.Y')}}">
            <input type="hidden" name="date_to" value="{{request()->date_to && count(explode('.', request()->date_to))==3 ? request()->date_to : date('d.m.Y')}}">
        </form>

        <div class="tbl-wrap tbl01">
            <table>
                <thead>
                    <tr>
                        @php
                            $query = [];
                            if(request()->date_from) $query['date_from'] = request()->date_from;
                            if(request()->date_to) $query['date_to'] = request()->date_to;
                        @endphp
                        <th class="th-sortable">
                            <div class="th-title">Дата</div>
                            <a href="{{ route('cabinet.statistic', array_merge($query, ['site' => $site->id ? $site->id : '', 'sort' => 'date-'.($ofield=='date' ? ($omethod=='desc' ? 'asc' : 'desc') : 'desc')])) }}" class="btn-action-sort {{$ofield=='date' ? ($omethod=='desc' ? 'down' : 'up') : 'down'}}"></a>
                        </th>
                        <th class="th-sortable">
                            <div class="th-title">Скачивания</div>
                            <a href="{{ route('cabinet.statistic', array_merge($query, ['site' => $site->id ? $site->id : '', 'sort' => 'cnt_lg-'.($ofield=='cnt_lg' ? ($omethod=='desc' ? 'asc' : 'desc') : 'desc')])) }}" class="btn-action-sort {{$ofield=='cnt_lg' ? ($omethod=='desc' ? 'down' : 'up') : 'down'}}"></a>
                        </th>
                        <th class="th-sortable">
                            <div class="th-title">Уникальные скачивания</div>
                            <a href="{{ route('cabinet.statistic', array_merge($query, ['site' => $site->id ? $site->id : '', 'sort' => 'cnt_lg_u-'.($ofield=='cnt_lg_u' ? ($omethod=='desc' ? 'asc' : 'desc') : 'desc')])) }}" class="btn-action-sort {{$ofield=='cnt_lg_u' ? ($omethod=='desc' ? 'down' : 'up') : 'down'}}"></a>
                        </th>
                        <th class="th-sortable">
                            <div class="th-title">Запуски</div>
                            <a href="{{ route('cabinet.statistic', array_merge($query, ['site' => $site->id ? $site->id : '', 'sort' => 'cnt_lo-'.($ofield=='cnt_lo' ? ($omethod=='desc' ? 'asc' : 'desc') : 'desc')])) }}" class="btn-action-sort {{$ofield=='cnt_lo' ? ($omethod=='desc' ? 'down' : 'up') : 'down'}}"></a>
                        </th>
                        <th class="th-sortable">
                            <div class="th-title">Уникальные запуски</div>
                            <a href="{{ route('cabinet.statistic', array_merge($query, ['site' => $site->id ? $site->id : '', 'sort' => 'cnt_lo_u-'.($ofield=='cnt_lo_u' ? ($omethod=='desc' ? 'asc' : 'desc') : 'desc')])) }}" class="btn-action-sort {{$ofield=='cnt_lo_u' ? ($omethod=='desc' ? 'down' : 'up') : 'down'}}"></a>
                        </th>
                        <th class="th-sortable">
                            <div class="th-title">Установки</div>
                            <a href="{{ route('cabinet.statistic', array_merge($query, ['site' => $site->id ? $site->id : '', 'sort' => 'installs-'.($ofield=='installs' ? ($omethod=='desc' ? 'asc' : 'desc') : 'desc')])) }}" class="btn-action-sort {{$ofield=='installs' ? ($omethod=='desc' ? 'down' : 'up') : 'down'}}"></a>
                        </th>
                        <th class="th-sortable">
                            <div class="th-title">Уникальные установки</div>
                            <a href="{{ route('cabinet.statistic', array_merge($query, ['site' => $site->id ? $site->id : '', 'sort' => 'uinstalls-'.($ofield=='uinstalls' ? ($omethod=='desc' ? 'asc' : 'desc') : 'desc')])) }}" class="btn-action-sort {{$ofield=='uinstalls' ? ($omethod=='desc' ? 'down' : 'up') : 'down'}}"></a>
                        </th>
                        <th class="th-sortable">
                            <div class="th-title">Доход</div>
                            <a href="{{ route('cabinet.statistic', array_merge($query, ['site' => $site->id ? $site->id : '', 'sort' => 'income-'.($ofield=='income' ? ($omethod=='desc' ? 'asc' : 'desc') : 'desc')])) }}" class="btn-action-sort {{$ofield=='income' ? ($omethod=='desc' ? 'down' : 'up') : 'down'}}"></a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stats as $date => $data)
                        {{--@if($data['cnt_lg']!='0' && $data['cnt_lg_u']!='0' && $data['cnt_lo']!='0' && $data['cnt_lo_u']!='0' && $data['installs']!='0' && $data['uinstalls']!='0' && $data['income']!='0.00')--}}
                        <tr>
                            <td>{{$date}}</td>
                            <td>{{$data['cnt_lg']}}</td>
                            <td>{{$data['cnt_lg_u']}}</td>
                            <td>{{$data['cnt_lo']}}</td>
                            <td>{{$data['cnt_lo_u']}}</td>
                            <td>{{$data['installs']}}</td>
                            <td>{{$data['uinstalls']}}</td>
                            <td>{{$data['income']}}</td>
                        </tr>
                        {{--@endif--}}
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /tbl wrap -->
    </div>
@endsection

@push('scripts')
<script>
    function onSubmitDate(obj){
        var rangeDate = $('#dateRangePicker').val().split(' to ');
        $('[name="date_from"]').val(rangeDate[0]);
        $('[name="date_to"]').val(rangeDate[1]);
        obj[0].submit();

    }

    $('#dateRangePicker').dateRangePicker({
        format: 'DD.MM.YYYY',
        inline:true,
        container: '#date-range12-container',
        alwaysOpen:true
    });
    $('#dateRangePicker').data('dateRangePicker').setDateRange($('[name="date_from"]').val(),$('[name="date_to"]').val());
    {{--var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Загрузки", "Уникальные загрузки", "Открыте", "Уникальные открыте", "Доход"],
            datasets: [
                {
                    label: 'Статистика',
                    backgroundColor: 'red',
                    borderColor: 'red',
                    data: [ {{$chart['downloads']}},{{$chart['downloads_unique']}},{{$chart['open']}},{{$chart['open_unique']}},{{$chart['income']}} ]
                }
            ]
        },
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            scales: {
                yAxes: [{
                    ticks: {
                        suggestedMin: 0.1,
                    }
                }]
            }
        }
    });--}}
    /*function rebuildDateHiddenFields(){
        $('[name="date_from"]').val($('#date_from_day').val()+'.'+$('#date_from_month').val()+'.'+$('#date_from_year').val());
        $('[name="date_to"]').val($('#date_to_day').val()+'.'+$('#date_to_month').val()+'.'+$('#date_to_year').val());
    }*/
</script>
@endpush