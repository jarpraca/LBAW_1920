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
$displaySearch = true;

if (isset($_SESSION['user']))
    $loggedin = true;

include('../templates/common/header.php');
?>
<div class="text-left" id="homepage">
    <!-- <h2 class="mt-3">Welcome, </h2>
    <p>We hope you enjoy our website, we put on a lot of work to make sure you had the best, most simplified experience. Take part in our selection of auctions and hopefully you will find your perfect pet companion with us. Good Luck! Don't forget to be wise about how you handle your money and that you must be 18 or older to take part in our auctions. Go on and bid, they're waiting for you!</p>
     -->
    <h2 class="mt-3">Trending</h2>
    <div class="d-flex flex-wrap text-left justify-content-around">
        <div class="card mt-4">
            <img class="card-img-top" src="../images/monkey.jpg" alt="Card image cap">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title font-weight-bold">Macaco da Nazaré</h5>
                <div class="d-flex flex-row justify-content-between mr-2">
                    <p class="card-text">500€</p>
                    <p class="card-text">2 anos</p>
                </div>

                <p class="card-text smallFont">Ending time </p>
                <p>30-03-2020 23:59</p>
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <i class="far fa-eye fa-2x colorGrey"></i>
                    <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <img class="card-img-top" src="../images/lion.jfif" alt="Card image cap">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title font-weight-bold">Macaco da Nazaré 2</h5>
                <div class="d-flex flex-row justify-content-between mr-2">
                    <p class="card-text">500€</p>
                    <p class="card-text">2 anos</p>
                </div>

                <p class="card-text smallFont">Ending time </p>
                <p>30-03-2020 23:59</p>
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <i class="far fa-eye fa-2x colorGrey"></i>
                    <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <img class="card-img-top" src="../images/monkey.jpg" alt="Card image cap">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title font-weight-bold">Macaco da Nazaré 3</h5>
                <div class="d-flex flex-row justify-content-between mr-2">
                    <p class="card-text">500€</p>
                    <p class="card-text">2 anos</p>
                </div>

                <p class="card-text smallFont">Ending time </p>
                <p>30-03-2020 23:59</p>
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <i class="far fa-eye fa-2x colorGrey"></i>
                    <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mt-3">Categories</h2>
    <div class="d-flex flex-row flex-wrap mt-4 rounded overflow-hidden">
        <a class="card text-white border-0 rounded-0 category-card" href="search.php">
            <img class="card-img rounded-0" src="../images/mammals.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h3 class="card-title text-center text-shadow">Mammals</h3>
            </div>
        </a>
        <a class="card text-white border-0 rounded-0 category-card" href="search.php">
            <img class="card-img rounded-0" src="../images/insects.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h3 class="card-title text-center text-shadow">Insects</h3>
            </div>
        </a>
        <a class="card text-white border-0 rounded-0 category-card" href="search.php">
            <img class="card-img rounded-0" src="../images/reptiles.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h3 class="card-title text-center text-shadow">Reptiles</h3>
            </div>
        </a>
        <a class="card text-white border-0 rounded-0 category-card" href="search.php">
            <img class="card-img rounded-0" src="../images/birds.png" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h3 class="card-title text-center text-shadow">Birds</h3>
            </div>
        </a>
        <a class="card text-white border-0 rounded-0 category-card" href="search.php">
            <img class="card-img rounded-0" src="../images/fishes.jpeg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h3 class="card-title text-center text-shadow">Fishes</h3>
            </div>

        </a>
        <a class="card text-white border-0 rounded-0 category-card" href="search.php">
            <img class="card-img rounded-0" src="../images/amphibians.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h3 class="card-title text-center text-shadow">Amphibians</h3>
            </div>
        </a>
    </div>
</div>
<?php
include('../templates/common/footer.php');
?>