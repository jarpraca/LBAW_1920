@extends('layouts.app')

@section('title','Reset Password')

@section('content')
<div id="signup_bg">
    <div id="main">
        <div id="signupform">
            <h2 class="">Reset Your Password</h2>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <label style="display:none" for="token"></label>
                <input type="hidden" name="token" id="token" value="{{ $token }}">

                <label class="form-check-label ml-1 mt-3" for="email">Email Address <span class="text-danger">* </span></label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email }}" readonly>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror


                <label class="form-check-label ml-1 mt-3" for="password">Password <span class="text-danger">* </span></label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label class="form-check-label ml-1 mt-3" for="password-confirm">Confirm Password <span class="text-danger">* </span></label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">


                <div class="form-group mt-4">
                    <div class=" d-flex align-self-center justify-content-center align-items-center">
                        <button class="mx-auto btn btn-green" type="submit">Reset Password</button>
                    </div>
                </div>
               
            </form>
        </div>
    </div>
</div>
@endsection