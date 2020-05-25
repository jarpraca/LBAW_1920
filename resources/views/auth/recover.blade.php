@extends('layouts.app')

@section('title','Recover Password')

@section('content')
<div id="signup_bg">
    <div id="main">
        <div id="loginform" class="px-4">
            <h2 class="">RECOVER PASSWORD</h2>

            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <label style="display:none" for="email"></label>
                <input class="" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                @if ($errors->has('email'))
                <span class="error ">
                    {{ $errors->first('email') }}
                </span>
                @endif

                <div class="form-group">
                    <div class=" d-flex align-self-center justify-content-center align-items-center">
                        <button class="mx-auto btn btn-green" type="submit">SUMBIT</button>
                    </div>
                </div>

                <div class="d-flex mt-2 flex-row justify-content-center align-items-center">
                    <p class="">Already have an account?&nbsp;</p>
                    <a class="text-dark" href="{{ route('login') }}">Sign In</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection