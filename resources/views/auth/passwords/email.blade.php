@extends('layouts.auth')

@section('content')
    <div class="main-form-wrap">
        <form action="{{ route('password.email') }}" method="POST" class="form">
            {{ csrf_field() }}

            <div class="frm-title">Восстановить пароль</div>
            @if (session('status'))
                <div class="frm-row alert alert-success" style="color: white;">
                    {{ session('status') }}
                </div>
            @endif
            <div class="frm-row">
                <input type="email" placeholder="E-mail" name="email" value="{{ old('email') }}" required {{$errors->has('email') ? 'class=inp-error':''}}>
                @if ($errors->has('email')) <div class="frm-error-message">{{ $errors->first('email') }}</div> @endif
            </div>
            <div class="frm-row-submit">
                <input type="submit" value="Восстановить">
            </div>
        </form>
    </div>
@endsection