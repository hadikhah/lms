@extends('User::Front.master')

@section('content')
    <form method="post" action="{{ route('password.sendVerifyCodeEmail') }}" class="form">
        @csrf
        <a class="account-logo" href="/">
            <img src="/img/weblogo.png" height="100" alt="">
        </a>
        <div class="form-content form-account">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <input type="text" name="email" id="email" class="txt-l txt @error('email') is-invalid @enderror"
                   placeholder="{{__("email")}}"
                   value="{{ old('email') }}" required autocomplete="email" autofocus
            >
            @error('email')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <br>
            <button type="submit" class="btn btn-recoverpass">{{__("recover")}}</button>
        </div>
        <div class="form-footer">
            <a href="{{ route('login') }}">{{__("login page")}}</a>
        </div>
    </form>
@endsection
