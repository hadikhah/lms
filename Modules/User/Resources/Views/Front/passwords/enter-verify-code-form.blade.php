@extends('User::Front.master')

@section('content')
    <div class="account act">
        <form action="{{ route('password.checkVerifyCode') }}" class="form" method="post">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <a class="account-logo" href="/">
                <img src="/img/weblogo.png" height="100" alt="">
            </a>
            <div class="card-header">
                <p class="activation-code-title">

                    {{__("The recovery code has been sent to :email",["email"=> request()->email])}} ,
                    {{__("The email might have been sent to the spam folder")}}
                </p>
            </div>
            <div class="form-content form-content1">
                <input name="verify_code" required class="activation-code-input" placeholder="{{__("activate")}}">
                @error('verify_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <br>
                <button class="btn i-t">{{__("confirm")}}</button>
                <a href="{{ route("password.sendVerifyCodeEmail") }}?email={{ request("email") }}">
                    {{__("resend verification code")}}
                </a>

            </div>
            <div class="form-footer">
                <a href="{{ route('register') }}">{{__("login page")}}</a>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="/js/activation-code.js"></script>
@endsection
