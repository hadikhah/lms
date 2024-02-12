@extends('User::Front.master')

@section('content')
    <div class="account act">
        <form action="{{ route('verification.verify') }}" class="form" method="post">
            @csrf
            <a class="account-logo" href="/">
                <img src="/img/weblogo.png" height="100" alt="">
            </a>
            <div class="card-header">

                <p class="activation-code-title">
                    {{__("Please enter the code sent to the :email",["email"=>auth()->user()->email])}} .
                    {{__("The email might have been sent to the spam folder")}} .
                    {{__("Did you enter your email incorrectly")}} .<a
                            href="{{ route('users.profile') }}">{{__("click to edit your email")}}</a>
                </p>
            </div>
            <div class="form-content form-content1">
                <input name="verify_code" required class="activation-code-input"
                       placeholder="{{__("activation code")}}">
                @error('verify_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <br>
                <button class="btn i-t">{{__("confirm")}}</button>
                <a href="#" onclick="
                event.preventDefault();
                document.getElementById('resend-code').submit()
                ">{{__("resend verification code")}}</a>

            </div>
            <div class="form-footer">
                <a href="{{ route('register') }}">{{__("register page")}}</a>

            </div>
        </form>

        <form id="resend-code" action="{{ route('verification.resend') }}" method="post">
            @csrf
        </form>
    </div>
@endsection

@section('js')
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="/js/activation-code.js"></script>
@endsection
