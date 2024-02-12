@extends('User::Front.master')

@section('content')
    <form action="" class="form" method="post">
        <a class="account-logo" href="index.html">
            <img src="img/weblogo.png" height="100" alt="">
        </a>
        <div class="form-content form-account">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="text" class="txt @error('name') is-invalid @enderror" placeholder="{{__("full name")}} *"
                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                >
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input id="email" type="email" class="txt txt-l @error('email') is-invalid @enderror"
                       placeholder="{{__("email")}} *"
                       name="email" value="{{ old('email') }}" required autocomplete="email"
                >
                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                <input id="mobile" type="text" class="txt txt-l @error('mobile') is-invalid @enderror"
                       placeholder="{{__("mobile")}}"
                       name="mobile" value="{{ old('mobile') }}" autocomplete="mobile"
                >
                @error('mobile')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror


                <input id="password" type="password" class="txt txt-l @error('password') is-invalid @enderror"
                       placeholder="{{__("password")}} *"
                       name="password" required autocomplete="new-password"
                >
                <input id="password-confirm" type="password" class="txt txt-l @error('password') is-invalid @enderror"
                       placeholder="{{__("confirm password")}} *"
                       name="password_confirmation" required autocomplete="new-password"
                >

                <span class="rules">
                    {{__("The password must be at least 6 characters long and a combination of uppercase letters, lowercase letters, numbers, and non-alphabetic characters such as !@#$%^&*().")}}

                </span>

                @error('password')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror


                <br>
                <button class="btn continue-btn">{{__("register")." ".__("and")." ".__("continue")}}</button>
            </form>
            <div class="form-footer">
                <a href="{{ route('login') }}">{{__("login page")}}</a>
            </div>
        </div>

    </form>
@endsection
