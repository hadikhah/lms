@extends('User::Front.master')

@section('content')
    <form action="{{ route('login') }}" class="form" method="post">
        @csrf

        <div class="row">

            <span>fa</span>
        </div>
        <div class="row">
            <a class="account-logo" href="/">
                <img src="/img/weblogo.png" height="100" alt="" height="100">
            </a>

        </div>
        <div class="form-content form-account">

            <input id="email" type="text" class="txt-l txt @error('email') is-invalid @enderror" name="email"
                   placeholder="{{__("email or phone number")}}" value="{{ old('email') }}" required
                   autocomplete="email" autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <input id="password" type="password" class="txt-l txt" placeholder="{{__("password")}}"
                   name="password" required autocomplete="current-password"
            >
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <br>
            <button class="btn btn--login">{{__("login")}}</button>
            <label class="ui-checkbox">
                {{__("remember me")}}
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="checkmark"></span>
            </label>
            <div class="recover-password">
                <a href="{{ route('password.request') }}">{{__("reset password")}}</a>
            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('register') }}">{{__("sign up")}}</a>
        </div>
    </form>
@endsection
