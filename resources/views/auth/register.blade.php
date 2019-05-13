@extends('layouts.auth')

@section('content')
    <div class="main-form-wrap">
        <form action="{{ route('register') }}" class="form" method="POST">
            {{ csrf_field() }}

            <div class="frm-title">Регистрация</div>
            @if (session('confirmation-success'))
                <div class="frm-row alert alert-success" style="color: white;">
                    {{ session('confirmation-success') }}
                </div>
            @endif
            <div class="frm-row">
                <input type="text" placeholder="Логин" name="username" value="{{ old('username') }}" required autofocus {{$errors->has('username') ? 'class=inp-error':''}}>
                @if ($errors->has('username')) <div class="frm-error-message">{{ $errors->first('username') }}</div> @endif
            </div>
            <div class="frm-row">
                <input type="email" placeholder="E-Mail" name="email" value="{{ old('email') }}" required {{$errors->has('email') ? 'class=inp-error':''}}>
                @if ($errors->has('email')) <div class="frm-error-message">{{ $errors->first('email') }}</div> @endif
            </div>
            <div class="frm-row">
                <input type="password" placeholder="Пароль" name="password" required {{$errors->has('password') ? 'class=inp-error':''}}>
                @if ($errors->has('password')) <div class="frm-error-message">{{ $errors->first('password') }}</div> @endif
            </div>
            <div class="frm-row">
                <input type="password" placeholder="Подтверждение пароля" name="password_confirmation" required>
            </div>
            <div class="frm-row">
                <input type="text" placeholder="Skype" name="skype" value="{{ old('skype') }}">
            </div>
            <div class="frm-row">
                <input type="text" placeholder="ICQ" name="icq" value="{{ old('icq') }}">
            </div>
            <div class="frm-row">
                <input type="text" placeholder="WMR" name="wmr" value="{{ old('wmr') }}" required {{$errors->has('wmr') ? 'class=inp-error':''}}>
                @if ($errors->has('wmr')) <div class="frm-error-message">{{ $errors->first('wmr') }}</div> @endif
            </div>
            <div class="frm-row">
                <input type="text" placeholder="Инвайт" name="invite" value="{{ old('invite') }}" required {{$errors->has('invite') ? 'class=inp-error':''}}>
                @if ($errors->has('invite')) <div class="frm-error-message">{{ $errors->first('invite') }}</div> @endif
            </div>
            <div class="frm-row-submit">
                <input type="submit" value="Зарегистрироваться">
            </div>
        </form>
    </div>
@endsection