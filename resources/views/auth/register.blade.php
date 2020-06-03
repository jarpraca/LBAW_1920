@extends('layouts.app')

@section('title','Sign Up')

@section('content')

<meta property="og:title" content="BidMonkeys- Your animal auction website" />
<meta property="og:description" content="Sign up you won't regret it" />
<meta property="og:image" content="{{asset('assets/logo.png')}}" />
<meta property="og:locale" content="en_GB" />


<div id="signup_bg">
    <div id="main">
        <div id="signupform">
            <h2 class="">SIGN UP</h2>

            <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label class="form-check-label ml-1 mt-3" for="name">Name <span class="text-danger">* </span></label>
                    <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="First and Last Name" required autofocus>
                    @if ($errors->has('name'))
                    <span class="invalid-feedback d-block">
                        {{ $errors->first('name') }}
                    </span>
                    @endif
                    <label class="form-check-label ml-1 mt-3" for="email">Email Address <span class="text-danger">* </span></label>
                    <input id="email" type="email" name="email"  class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" required autofocus>
                    @if ($errors->has('email'))
                    <span class="invalid-feedback d-block">
                        {{ $errors->first('email') }}
                    </span>
                    @endif
                    <label style="display:none" for="password"></label>
                    <label class="form-check-label ml-1 mt-3" for="password">Password <span class="text-danger">* </span></label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                    @if ($errors->has('password'))
                    <span class="invalid-feedback d-block">
                        {{ $errors->first('password') }}
                    </span>
                    @endif
                    <label class="form-check-label ml-1 mt-3" for="password-confirm">Confirm Password <span class="text-danger">* </span></label>
                    <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>

                <!-- <div class="form-group">
                    <div class="d-flex align-self-center justify-content-around align-items-center">
                        <button class="btn btn-outline-black ml-0">
                            Sign up with&nbsp;
                            <i class="fab fa-facebook-f"></i>
                        </button>
                        <button class="btn btn-outline-black ml-0">
                            Sign up with&nbsp;
                            <i class="fab fa-google"></i>
                        </button>
                    </div>
                </div> -->

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