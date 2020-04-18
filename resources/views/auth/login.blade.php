@extends('layouts.app')

@section('content')
<div id="signup_bg">
    <div id="box">
        <div id="signup_infos">
            <div id="signup_msg">Don't have an account?</div>
            <a class="signup_btn" id="signup_btn" href="{{ route('register') }}">SIGN UP</a>
        </div>
    </div>
    <div id="main">
        <div id="loginform">
            <h1 class="mx-4">SIGN IN</h1>

            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <input class="mx-4" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                @if ($errors->has('email'))
                <span class="error mx-4">
                    {{ $errors->first('email') }}
                </span>
                @endif

                <input class="mx-4" id="password" type="password" name="password" placeholder="Password" required>
                @if ($errors->has('password'))
                <span class="error mx-4">
                    {{ $errors->first('password') }}
                </span>
                @endif

                <div class="mx-4 custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkbox-3" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label text-dark" for="checkbox-3">Remember me</label>
                </div>

                <div class="mx-4 d-flex align-self-center justify-content-around align-items-center">
                    <button class="ml-0" href="#">
                        Sign in with&nbsp;
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button class="ml-0" href="#">
                        Sign in with&nbsp;
                        <i class="fab fa-google"></i>
                    </button>
                </div>

                <div class="mx-4 d-flex align-self-center justify-content-center align-items-center">
                    <button class="mx-auto btn-green" type="submit">SIGN IN</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection