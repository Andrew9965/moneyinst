@extends('layouts.auth')

@section('content')
    <div class="main-form-wrap">
        <form action="{{ route('password.request') }}" class="form" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="frm-title">Сброс пароля</div>
            <div class="frm-row">
                <input type="email" placeholder="E-Mail" name="email" value="{{ $email or old('email') }}" required autofocus {{$errors->has('email') ? 'class=inp-error':''}}>
                @if ($errors->has('email')) <div class="frm-error-message">{{ $errors->first('email') }}</div> @endif
            </div>
            <div class="frm-row">
                <input type="password" placeholder="Пароль" name="password" required {{$errors->has('password') ? 'class=inp-error':''}}>
                @if ($errors->has('password')) <div class="frm-error-message">{{ $errors->first('password') }}</div> @endif
            </div>
            <div class="frm-row">
                <input type="password" placeholder="Подтверждение пароля" name="password_confirmation" required>
            </div>
            <div class="frm-row-submit">
                <input type="submit" value="Сбросить пароль">
            </div>
        </form>
    </div>
@endsection