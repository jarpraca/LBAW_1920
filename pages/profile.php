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

$logedin = false;
$displaySearch = true;

if (isset($_SESSION['user']))
    $logedin = true;

include('../templates/common/header.php');
?>
<div class="mainBody" id="profile">
    <div id="profile_top">
        <div id="profile_img">
            <img src="../images/profilePicture.jpg">
        </div>
        <div id="profile_info">
            <label>Nome:</label>
            <label>E-mail:</label>
            <button>Editar:</button>
        </div>
    </div>

    <div class="collapsible">
        <button type="button" class="collapsible_btn">Purchase History</button>
        <div class="collapsible_content">
            <p>Lorem ipsum...</p>
        </div>
    </div>
    
    <div class="collapsible">
        <button type="button" class="collapsible_btn">My auctions</button>
        <div class="collapsible_content">
            <p>Lorem ipsum...</p>
        </div>
    </div>

    <div class="collapsible">
        <button type="button" class="collapsible_btn">Ongoing</button>
        <div class="collapsible_content">
            <p>Lorem ipsum...</p>
        </div>
    </div>

    <div class="collapsible">
        <button type="button" class="collapsible_btn">Watchlist</button>
        <div class="collapsible_content">
            <p>Lorem ipsum...</p>
        </div>
    </div>


</div>

<?php
include('../templates/common/footer.php');
?>

<script src="../scripts/collapseAnimation.js"></script>