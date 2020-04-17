@extends('layouts.app')

@section('content')
<div id="signup_bg">
  <div id="box">
    <div id="login_msg">Don't have an account?</div>
    <a class="login_btn" id="login_btn" href="{{ route('login') }}">SIGN IN</a>
  </div>

  <div id="main">
    <div id="signupform">
      <h1 class="mx-4">SIGN UP</h1>

      <form method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        <input class="mx-4" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required autofocus>
        @if ($errors->has('name'))
        <span class="error">
          {{ $errors->first('name') }}
        </span>
        @endif
        <input class="mx-4" id="email" type="text" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
        @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
        @endif
        <input class="mx-4" id="password"  type="password" name="password" value="{{ old('password') }}" placeholder="Password" required autofocus>
        @if ($errors->has('password'))
        <span class="error">
          {{ $errors->first('password') }}
        </span>
        @endif

        <input class="mx-4" id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password" required>

        <button class="mx-4" href="#">
          Sign in with&nbsp;
          <i class="fab fa-facebook-f"></i>
        </button>
        <button class="mx-4" href="#">
          Sign in with&nbsp;
          <i class="fab fa-google"></i>
        </button>
        <button id="signup_submit_btn">SIGN UP</button>
      </form>
    </div>


  </div>
</div>
@endsection