@extends('layouts.auth')

@section('content')
    <div class="main-form-wrap">
        <form action="{{ route('login') }}" class="form" method="POST">
            {{ csrf_field() }}
            <div class="frm-title">Войти</div>
            @if (session('confirmation-success'))
                <div class="frm-row alert alert-success" style="color: white;">
                    {{ session('confirmation-success') }}
                </div>
            @endif
            @if (session('confirmation-danger'))
                <div class="frm-row alert alert-success" style="color: red;">
                    {!! session('confirmation-danger') !!}
                </div>
            @endif
            <div class="frm-row">
                <input type="text" placeholder="Логин" name="username" value="{{ old('username') }}" required autofocus {{$errors->has('username') ? 'class=inp-error':''}}>
                @if ($errors->has('username')) <div class="frm-error-message">{{ $errors->first('username') }}</div> @endif
            </div>
            <div class="frm-row">
                <input type="password" placeholder="Пароль" name="password" required {{$errors->has('password') ? 'class=inp-error':''}}>
                @if ($errors->has('password')) <div class="frm-error-message">{{ $errors->first('password') }}</div> @endif
            </div>
            <div class="frm-row-submit">
                <input type="submit" value="Войти">
            </div>
        </form>
    </div>
@endsection