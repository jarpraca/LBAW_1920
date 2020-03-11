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

$loggedin = true;
$admin = false;
$signUpPage = false;
$createAuctionPage = false;
$displaySearch = true;

// Content variables
$speciesName = "Guinea Monkey";
$name = "Albert";
$description = "This is a very cute 3-year-old guinea monkey called Albert!";
$category = "1";
$age = "3 years";
$startingPrice = "300";
$buyoutPrice = "1000";
// skils...
$color = 3;
$devStage = 3;
// images...

include('../templates/common/header.php');
include('../templates/auctions/editAuction.php');
include('../templates/common/footer.php');

?>
