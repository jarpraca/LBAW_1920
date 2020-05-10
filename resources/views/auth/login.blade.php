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

                <div class="d-flex mt-1 flex-row align-items-center">
                    <h6>Forgot password?&nbsp;</h6>
                    <a class="text-dark" href="{{ route('password.request') }}">
                        <h6>Recover</h6>
                    </a>
                </div>


                <div class="form-group">
                    <div class="d-flex justify-content-around align-items-center">
                        
                        <fb:login-button class="btn btn-outline-black ml-0" scope="public_profile,email" onlogin="checkLoginState();">
                            Sign in with&nbsp;
                            <i class="fab fa-facebook-f"></i>
                        </fb:login-button>
                        
                        <button class="btn btn-outline-black ml-0 customGPlusSignIn" id="customBtn">
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
                <div class="d-flex mt-2 flex-row justify-content-center align-items-center">
                    <p>Don't have an account?&nbsp;</p>
                    <a class="text-dark" href="{{ route('register') }}">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
    <script>
  var googleUser = {};
  var startApp = function() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: '69365655270-8j8f12sd8t3qh09o2pf235ke185rb9rk.apps.googleusercontent.com',
        cookiepolicy: 'single_host_origin',
        // Request scopes in addition to 'profile' and 'email'
        //scope: 'additional_scope'
      });
      attachSignin(document.getElementById('customBtn'));
    });
  };

  function attachSignin(element) {
    console.log(element.id);
    auth2.attachClickHandler(element, {},
        function(googleUser) {
          document.getElementById('name').innerText = "Signed in: " +
              googleUser.getBasicProfile().getName();
        }, function(error) {
          alert(JSON.stringify(error, undefined, 2));
        });
  }
  </script>
  <script>startApp();</script>
</div>


@endsection