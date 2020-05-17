@extends('layouts.app')

@section('content')
<div id="signup_bg">
    <div id="main">
        <div id="signupform">
            <h2 class="">SIGN UP</h2>

            <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <input class="" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required autofocus>
                    @if ($errors->has('name'))
                    <span class="error">
                        {{ $errors->first('name') }}
                    </span>
                    @endif
                    <input class="" id="email" type="text" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                    @if ($errors->has('email'))
                    <span class="error">
                        {{ $errors->first('email') }}
                    </span>
                    @endif
                    <input class="" id="password" type="password" name="password" value="{{ old('password') }}" placeholder="Password" required autofocus>
                    @if ($errors->has('password'))
                    <span class="error">
                        {{ $errors->first('password') }}
                    </span>
                    @endif

                    <input class="" id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>

                <!-- <div class="custom-file ">
                    <input id="profile_picture" type="file" class="form-control" name="profile_picture">
                    <label class="custom-file-label" for="profile_picture" id="profile_picture_label">Add Photo</label>
                </div> -->

                <div class="form-group">
                    <div class="d-flex align-self-center justify-content-around align-items-center">
                        <button class="btn btn-outline-black ml-0" href="#">
                            Sign up with&nbsp;
                            <i class="fab fa-facebook-f"></i>
                        </button>
                        <button class="btn btn-outline-black ml-0" href="#">
                            Sign up with&nbsp;
                            <i class="fab fa-google"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex align-self-center justify-content-center align-items-center">
                        <button class="mx-auto btn btn-green" type="submit">SIGN UP</button>
                    </div>
                </div>

                <div class="d-flex mt-2 flex-row justify-content-center align-items-center">
                    <p class="">Already have an account?&nbsp;</p>
                    <a class="text-dark font-weight-bold" href="{{ route('login') }}">Sign In</a>
                </div>
            </form>
        </div>


    </div>
</div>
@endsection