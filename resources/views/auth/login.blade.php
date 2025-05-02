@extends('layouts.app')

@section('content')
    <div class="center-block">
        <div class="registration-form regular-form">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <h3 class="head-main head-task">Вход</h3>
            <div class="form-group @error('email') has-error @enderror">
                <label class="control-label" for="email-user">Email</label>
                <input id="email-user" type="text" name="email" value="{{ old('email') }}">
                <span class="help-block">@error('email'){{ $message }}@enderror</span>
            </div>
            <div class="form-group @error('password') has-error @enderror">
                <label class="control-label" for="password">Пароль</label>
                <input id="password" type="password" name="password">
                <span class="help-block">@error('password'){{ $message }}@enderror</span>
            </div>

            <input type="submit" class="button button--blue" value="Войти">

            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Забыли пароль?') }}
                </a>
            @endif
        </form>
        </div>
    </div>
@endsection
