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
$signUpPage = false;
$createAuctionPage = false;
if (isset($_SESSION['user']))
    $loggedin = true;
$displaySearch = true;

include('../templates/common/header.php');

// if (!isset($_GET['id']))
//     header('location: homepage.php');

// $habitation = getHabitationById($_GET['id']);
// $dateFrom = null;
// if (isset($_GET['dateFrom']))
//     $dateFrom = $_GET['dateFrom'];
// $dateTo = null;
// if (isset($_GET['dateTo']))
//     $dateTo = $_GET['dateTo'];

// if ($dateFrom != null && $dateTo != null && !isAvailable($_GET['id'], $dateFrom, $dateTo))
//     header('location: homepage.php');

include('../templates/auctions/viewAuction.php');
include('../templates/common/footer.php');
