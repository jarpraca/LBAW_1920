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
    <h2 class="mt-3">Welcome, </h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et pulvinar dui, tincidunt faucibus tortor. Curabitur feugiat quam arcu. Nulla malesuada quis neque sed ultrices. Vivamus non purus et ipsum ultricies ornare sit amet eget erat. Nam quam ex, sodales sit amet dapibus pellentesque, suscipit quis eros. Nulla vestibulum dapibus urna, non fringilla magna faucibus vel. Nam pharetra sapien nisl, ut rutrum lacus pulvinar lacinia. Phasellus justo lorem, venenatis id libero a, varius vehicula arcu. Mauris eget urna urna. Etiam quam nulla, ultrices non est ac, laoreet blandit nisi. Morbi quis leo nec tellus consectetur consequat ut et massa. Nam laoreet ipsum quis finibus fermentum. Praesent sit amet nisl luctus, sollicitudin nulla sed, mattis elit.</p>
    
    <h2 class="mt-3">Trending</h2>
    <div class="d-flex flex-wrap text-left justify-content-around">
        <div class="card mt-4">
            <img class="card-img-top" src="../images/monkey.jpg" alt="Card image cap">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Macaco da Nazaré</h5>
                <p class="card-text">500€</p>
                <p class="card-text">2 anos</p>
                <p class="card-text">Ending time: 30-03-2020 23:59</p>
                <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
            </div>
        </div>
        <div class="card mt-4">
            <img class="card-img-top" src="../images/monkey.jpg" alt="Card image cap">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Macaco da Nazaré 2</h5>
                <p class="card-text">500€</p>
                <p class="card-text">2 anos</p>
                <p class="card-text">Ending time: 30-03-2020 23:59</p>
                <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
            </div>
        </div>
        <div class="card mt-4">
            <img class="card-img-top" src="../images/monkey.jpg" alt="Card image cap">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Macaco da Nazaré 3</h5>
                <p class="card-text">500€</p>
                <p class="card-text">2 anos</p>
                <p class="card-text">Ending time: 30-03-2020 23:59</p>
                <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
            </div>
        </div>
    </div>

    <h2 class="mt-3">Categories</h2>
    <div class="d-flex flex-row flex-wrap mt-4 rounded overflow-hidden">
        <a class="card text-white border-0 rounded-0 category-card" href="viewAuctionGuest.php">
            <img class="card-img rounded-0" src="../images/mammals.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h3 class="card-title text-center text-shadow">Mammals</h3>
            </div>
        </a>
        <a class="card text-white border-0 rounded-0 category-card" href="viewAuctionGuest.php">
            <img class="card-img rounded-0" src="../images/insects.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h3 class="card-title text-center text-shadow">Insects</h3>
            </div>
        </a>
        <a class="card text-white border-0 rounded-0 category-card" href="viewAuctionGuest.php">
            <img class="card-img rounded-0" src="../images/reptiles.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h3 class="card-title text-center text-shadow">Reptiles</h3>
            </div>
        </a>
        <a class="card text-white border-0 rounded-0 category-card" href="viewAuctionGuest.php">
            <img class="card-img rounded-0" src="../images/birds.png" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h3 class="card-title text-center text-shadow">Birds</h3>
            </div>
        </a>
        <a class="card text-white border-0 rounded-0 category-card" href="viewAuctionGuest.php">
            <img class="card-img rounded-0" src="../images/fishes.jpeg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h3 class="card-title text-center text-shadow">Fishes</h3>
            </div>
        </a>
        <a class="card text-white border-0 rounded-0 category-card" href="viewAuctionGuest.php">
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