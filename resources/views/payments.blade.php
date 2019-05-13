@extends('layouts.cabinet')

@section('title', '| Выплаты')

@section('content')
    <div class="cnt">
        <h1>Выплаты</h1>
        <div class="tbl-wrap tbl-fixed">
            <table>
                <thead>
                <tr>
                    <th class="th-sortable">
                        <div class="th-title">Дата</div>
                        <a href="{{route('cabinet.payments', ['sort' => 'created_at-'.($ofield=='created_at' ? ($omethod=='desc' ? 'asc' : 'desc') : 'desc')])}}" class="btn-action-sort {{$ofield=='created_at' ? ($omethod=='desc' ? 'down' : 'up') : 'down'}}"></a>
                    </th>
                    <th class="th-sortable">
                        <div class="th-title">С</div>
                        <a href="{{route('cabinet.payments', ['sort' => 'date_from-'.($ofield=='date_from' ? ($omethod=='desc' ? 'asc' : 'desc') : 'desc')])}}" class="btn-action-sort {{$ofield=='date_from' ? ($omethod=='desc' ? 'down' : 'up') : 'down'}}"></a>
                    </th>
                    <th class="th-sortable">
                        <div class="th-title">По</div>
                        <a href="{{route('cabinet.payments', ['sort' => 'date_to-'.($ofield=='date_to' ? ($omethod=='desc' ? 'asc' : 'desc') : 'desc')])}}" class="btn-action-sort {{$ofield=='date_to' ? ($omethod=='desc' ? 'down' : 'up') : 'down'}}"></a>
                    </th>
                    <th class="th-sortable">
                        <div class="th-title">Сумма</div>
                        <a href="{{route('cabinet.payments', ['sort' => 'amount-'.($ofield=='amount' ? ($omethod=='desc' ? 'asc' : 'desc') : 'desc')])}}" class="btn-action-sort {{$ofield=='amount' ? ($omethod=='desc' ? 'down' : 'up') : 'down'}}"></a>
                    </th>
                    <th class="th-sortable">
                        <div class="th-title">Номер кошелька</div>
                    </th>
                    <th class="th-sortable">
                        <div class="th-title">Примечание</div>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{$payment->created_at}}</td>
                    <td>{{$payment->date_from}}</td>
                    <td>{{$payment->date_to}}</td>
                    <td>{{number_format($payment->amount, 2, ',', ' ')}} ₽</td>
                    <td>{{$payment->wallet_number}}</td>
                    <td>{{$payment->note}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if(!count($payments))
            <center><h1>Пусто</h1></center>
        @endif
        {{ $payments->links() }}
    </div>
@endsection