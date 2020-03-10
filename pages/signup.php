<?php
function generate_random_token()
{
    return bin2hex(openssl_random_pseudo_bytes(32));
}
session_start();
session_regenerate_id(true);

if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}

$loggedin = false;
$admin = false;
$signUpPage = true;
$createAuctionPage = false;
$displaySearch = false;

if (isset($_SESSION['user']))
    $loggedin = true;

include('../templates/common/header.php');
?>
<div id="signup_bg">

    <div id="box">
        <div id="main"></div>

        <div id="loginform">
            <h1>LOGIN</h1>
            <input type="email" placeholder="Email" class="mx-3"/>
            <input type="password" placeholder="Password"  class="mx-3"/>
            <button  class="mx-3">Log in with facebook</button>
            <button  class="mx-3">Log in with google</button>
            <button id="signup_submit_btn">LOGIN</button>
        </div>

        <div id="signupform">
            <h1>SIGN UP</h1>
            <input type="text" placeholder="Full Name" />
            <input type="email" placeholder="Email" />
            <input type="password" placeholder="Password" />
            <input type="password" placeholder="Confirm password" />
            <button>Sign up with facebook</button>
            <button>Sign up with google</button>
            <button id="signup_submit_btn">SIGN UP</button>
        </div>

        <div id="login_msg">Have an account?</div>
        <div id="signup_msg">Don't have an account?</div>

        <button class="login_btn" id="login_btn">LOGIN</button>
        <button class="signup_btn" id="signup_btn">SIGN UP</button>


    </div>

</div>

<?php
include('../templates/common/footer.php');
?>

<script src="../scripts/signupAnimation.js"></script>