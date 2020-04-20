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
        <input class="mx-4" id="password" type="password" name="password" value="{{ old('password') }}" placeholder="Password" required autofocus>
        @if ($errors->has('password'))
        <span class="error">
          {{ $errors->first('password') }}
        </span>
        @endif

        <input class="mx-4" id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password" required>

        <!-- <div class="custom-file mx-4">
          <input id="profile_picture" type="file" class="form-control" name="profile_picture">
          <label class="custom-file-label" for="profile_picture" id="profile_picture_label">Add Photo</label>
        </div> -->
        <div class="mx-4 d-flex align-self-center justify-content-around align-items-center">
          <button class="ml-0" href="#">
            Sign up with&nbsp;
            <i class="fab fa-facebook-f"></i>
          </button>
          <button class="ml-0" href="#">
            Sign up with&nbsp;
            <i class="fab fa-google"></i>
          </button>
        </div>

        <div class="mx-4 d-flex align-self-center justify-content-center align-items-center">
          <button class="mx-auto btn-green" type="submit">SIGN UP</button>
        </div>
      </form>
    </div>


  </div>
</div>
@endsection