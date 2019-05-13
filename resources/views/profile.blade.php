@extends('layouts.cabinet')

@section('title', '| '.Auth::user()->username)

@push('head_style')
<link rel="stylesheet" href="{{asset('packages/editable/css/jqueryui-editable.css')}}" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.0/themes/smoothness/jquery-ui.css" />
@endpush

@push('head_scripts')
<script src="https://code.jquery.com/ui/1.10.0/jquery-ui.min.js" integrity="sha256-hTpbeVXhgCmfO7nGcWp9d1kImKbzY6gN0Vo5u5wLuss=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('packages/editable/js/jqueryui-editable.js')}}"></script>
@endpush

@section('content')
    <div class="cnt">
        <h1>{{Auth::user()->username}}</h1>
        <div class="tbl-wrap tbl-att-first tbl-fixed tbl05">
            <table>
                <col class="col01">
                <col class="col02">
                <tbody>
                <tr>
                    <td>ID</td>
                    <td>{{Auth::user()->id}}</td>
                </tr>
                <tr>
                    <td>Имя</td>
                    <td><a data-xedit="name" href="#">{{Auth::user()->name}}</a>
                    </td>
                </tr>
                <tr>
                    <td>Фамилия</td>
                    <td><a data-xedit="last_name" href="#">{{Auth::user()->last_name}}</a>
                    </td>
                </tr>
                <tr>
                    <td>E-Mail</td>
                    <td>{{Auth::user()->email}}</td>
                </tr>
                <tr>
                    <td>ICQ</td>
                    <td><a data-xedit="icq" href="#">{{Auth::user()->icq}}</a>
                    </td>
                </tr>
                <tr>
                    <td>Skype</td>
                    <td><a data-xedit="skype" href="#">{{Auth::user()->skype}}</a>
                    </td>
                </tr>
                <tr>
                    <td>Кошелек WebMoney (WMR)</td>
                    <td>{{Auth::user()->wmr}}</td>
                </tr>
                <tr>
                    <td>Телеграмм</td>
                    <td><a data-xedit="telegram" href="#">{{Auth::user()->telegram}}</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="tbl-actions"><a href="#change_password">Сменить пароль</a></div>
        <div class="tbl-actions" id="password_area" style="display: none">
            <form action="{{ route('cabinet.profile_change_password') }}" method="POST">
                {{ csrf_field() }}
                <div class="frm-row">
                    <div class="frm-field half">
                        <label>Пароль</label>
                        <input type="password" name="password" value="">
                    </div>
                    <div class="frm-field half">
                        <label>Подтверждение пароля</label>
                        <input type="password" name="password_confirmation" value="">
                    </div>
                </div>
                <div class="frm-row-submit">
                    <input type="submit" value="Сменить">
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')


    <script>
        $('[href="#change_password"]').on('click', function(){
            $('#password_area').toggle('slow');
        });
        $(function(){
            $('[data-xedit]').each(function(){
                $(this).editable({
                    url: '{{route('cabinet.profile_edit', ['_token' => csrf_token()])}}',
                    name: $(this).data('xedit'),
                    pk: {{Auth::user()->id}},
                    type: 'text',
                    title: $(this).parents('tr').find('td:first').html(),
                    emptytext: 'Добавить'
                });
            });
        });
    </script>
@endpush