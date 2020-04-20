@extends('layouts.app')

@section('content')
<div id="signup_bg">
    <div id="main">
        <div id="loginform" class="px-4">
            <h2>SIGN IN</h2>

            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                @if ($errors->has('email'))
                <span class="error ">
                    {{ $errors->first('email') }}
                </span>
                @endif

                <input id="password" type="password" name="password" placeholder="Password" required>
                @if ($errors->has('password'))
                <span class="error ">
                    {{ $errors->first('password') }}
                </span>
                @endif

                <div class="form-group ml-1">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="checkbox-3" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label text-dark" for="checkbox-3">Remember me</label>
                    </div>
                    
                </div>

                <div class="form-group">
                    <div class="d-flex justify-content-around align-items-center">
                        <button class="btn btn-outline-black ml-0" href="#">
                            Sign in with&nbsp;
                            <i class="fab fa-facebook-f"></i>
                        </button>
                        <button class="btn btn-outline-black ml-0" href="#">
                            Sign in with&nbsp;
                            <i class="fab fa-google"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <div class=" d-flex align-self-center justify-content-center align-items-center">
                        <button class="mx-auto btn btn-green" type="submit">SIGN IN</button>
                    </div>
                </div>
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>

                <div class="d-flex mt-2 flex-row justify-content-center align-items-center">
                    <p>Don't have an account?&nbsp;</p>
                    <a class="text-dark" href="{{ route('register') }}">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection