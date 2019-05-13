@extends('layouts.cabinet')

@section('title', '| Баланс')

@section('content')
    <div class="cnt">
        <h1>Баланс</h1>
        <div class="tbl-wrap tbl-fixed tbl06">
            <table>
                <thead>
                <tr>
                    <th>Дата</th>
                    <th>Сумма</th>
                </tr>
                </thead>
                <tbody>
                @foreach($balances = \App\Models\Balance::myBalance() as $balance)
                <tr>
                    <td>{{$balance->created_at}}</td>
                    <td>{{number_format($balance->amount, 2, ',', ' ')}} ₽</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if(!count($balances))
            <center><h1>Пусто</h1></center>
        @endif
        {{ $balances->links() }}
    </div>
@endsection