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

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email }}" readonly>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<!-- @section('content')
<div id="signup_bg">
    <div id="main">
        <div id="signupform">
            <h2 class="">Reset Your Password</h2>
            <form method="POST" action="{{ route('password.update') }}">
                {{ csrf_field() }}
                <label style="display:none" for="email"></label>
                <input class="mt-3" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <label style="display:none" for="password"></label>
                <input class="mt-3" id="password" type="password" name="password" placeholder="Password" required>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <label style="display:none" for="password"></label>
                <input class="mt-3" id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">

                <div class="form-group mt-4">
                    <div class=" d-flex align-self-center justify-content-center align-items-center">
                        <button class="mx-auto btn btn-green" type="submit">Reset Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection -->