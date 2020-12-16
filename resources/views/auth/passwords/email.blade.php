@extends('layouts.app')

@section('title','Recover Password')

@section('content')
<div id="signup_bg">
    <div id="main">
        <div id="loginform" class="px-4">
            <h2>RECOVER PASSWORD</h2>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <div>
                            <label style="display:none" for="email"></label>
                            <input id="email" name="email" placeholder="Email Address" type="email" class="form-control @error('email') is-invalid @enderror mt-5" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="mx-auto btn btn-green">
                            {{ __('Send Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
