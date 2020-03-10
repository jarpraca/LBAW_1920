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
// if (isset($_SESSION['user']))
    $loggedin = true;
$displaySearch = true;

include('../templates/common/header.php');
include('../templates/auctions/viewAuction.php');
include('../templates/common/footer.php');
