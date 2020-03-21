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

if (isset($_SESSION['user']))
    $loggedin = true;

include('../templates/common/header.php');
?>
<div class="mainBody">
    <h1 class="mt-3 colorGreen">Profile</h1>
    <div class="d-flex flex-wrap align-items-center">

        <div class="mx-auto image-container">
            <img class="edit_profile_img" src="../images/profilePicture.jpg">
            <input id="image_upload" type="file" name="profile_photo" placeholder="Photo" required="" capture>

        </div>
        <div class="w-50 align-items-between image-container">

            <p class="mb-0">Name</p>
            <p class="font-weight-bold mt-0">John Doe</p>

            <p class="mb-0">E-mail</p>
            <p class="font-weight-bold mt-0">something@fe.up.pt</p>

            <div id="profile_edit">
                <a class="colorGreen text-decoration-underline mx-auto w-75" href="editProfile.php"><u>Edit</u></a>
            </div>
        </div>
    </div>

    <div class="collapsible mt-5 mb-4">
        <button class="collapsible_btn w-100 py-2 text-left">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <h5 class="font-weight-bold">Purchase History</h5>
                <i class=" fas fa-chevron-down mr-2 p-0"></i>
            </div>
        </button>
        <div class="collapsible_content bgColorGrey">
            <div class="d-flex flex-wrap text-left justify-content-around">
                <div class="card mt-4">
                    <img class="card-img-top" src="../images/lion.jfif" alt="Card image cap">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Macaco da Nazaré</h5>
                        <p class="card-text">700€</p>
                        <p class="card-text">5 anos</p>
                        <p class="card-text">Ending time: 30-02-2020 23:59</p>
                        <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                    </div>
                </div>
                <div class="card mt-4">
                    <img class="card-img-top" src="../images/fishes.jpeg" alt="Card image cap">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Macaco da Nazaré 2</h5>
                        <p class="card-text">500€</p>
                        <p class="card-text">2 anos</p>
                        <p class="card-text">Ending time: 02-03-2020 23:59</p>
                        <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                    </div>
                </div>
                <div class="card mt-4">
                    <img class="card-img-top" src="../images/insects.jpg" alt="Card image cap">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Macaco da Nazaré 3</h5>
                        <p class="card-text">500€</p>
                        <p class="card-text">2 anos</p>
                        <p class="card-text">Ending time: 20-02-2020 23:59</p>
                        <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="collapsible mt-2 mb-4">
        <button class="collapsible_btn w-100 py-2 text-left">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <h5 class="font-weight-bold">My Auctions</h5>
                <i class=" fas fa-chevron-down mr-2 p-0"></i>
            </div>
        </button>
        <div class="collapsible_content bgColorGrey">
            <div class="d-flex flex-wrap text-left justify-content-around">
                <div class="card mt-4">
                    <img class="card-img-top" src="../images/lion.jfif" alt="Card image cap">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Macaco da Nazaré</h5>
                        <p class="card-text">700€</p>
                        <p class="card-text">5 anos</p>
                        <p class="card-text">Ending time: 30-02-2020 23:59</p>

                        <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                    </div>
                </div>
                <div class="card mt-4">
                    <img class="card-img-top" src="../images/fishes.jpeg" alt="Card image cap">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Macaco da Nazaré 2</h5>
                        <p class="card-text">500€</p>
                        <p class="card-text">2 anos</p>
                        <p class="card-text">Ending time: 02-03-2020 23:59</p>
                        <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                    </div>
                </div>
                <div class="card mt-4">
                    <img class="card-img-top" src="../images/insects.jpg" alt="Card image cap">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Macaco da Nazaré 3</h5>
                        <p class="card-text">500€</p>
                        <p class="card-text">2 anos</p>
                        <p class="card-text">Ending time: 20-02-2020 23:59</p>
                        <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="collapsible mt-2 mb-4">
        <button class="collapsible_btn w-100 py-2 text-left">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <h5 class="font-weight-bold">Ongoing Auctions</h5>
                <i class=" fas fa-chevron-down mr-2 p-0"></i>
            </div>
        </button>
        <div class="collapsible_content bgColorGrey">
            <div class="d-flex flex-wrap text-left justify-content-around">
                <div class="card mt-4">
                    <img class="card-img-top" src="../images/animal3.jfif" alt="Card image cap">
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
                        <p class="card-text">800€</p>
                        <p class="card-text">6 meses</p>
                        <p class="card-text">Ending time: 18-03-2020 23:59</p>
                        <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                    </div>
                </div>
                <div class="card mt-4">
                    <img class="card-img-top" src="../images/animal2.jfif" alt="Card image cap">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Macaco da Nazaré 3</h5>
                        <p class="card-text">900€</p>
                        <p class="card-text">7 anos</p>
                        <p class="card-text">Ending time: 27-03-2020 23:59</p>
                        <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="collapsible mt-2 mb-4">
        <button class="collapsible_btn w-100 py-2 text-left">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <h5 class="font-weight-bold">Watchlist</h5>
                <i class=" fas fa-chevron-down mr-2 p-0"></i>
            </div>
        </button>
        <div class="collapsible_content">
            <div class="d-flex flex-wrap text-left justify-content-around">
                <div class="card mt-4">
                    <img class="card-img-top" src="../images/animal3.jfif" alt="Card image cap">
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
                        <p class="card-text">800€</p>
                        <p class="card-text">6 meses</p>
                        <p class="card-text">Ending time: 18-03-2020 23:59</p>

                        <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                    </div>
                </div>
                <div class="card mt-4">
                    <img class="card-img-top" src="../images/animal2.jfif" alt="Card image cap">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Macaco da Nazaré 3</h5>
                        <p class="card-text">900€</p>
                        <p class="card-text">7 anos</p>
                        <p class="card-text">Ending time: 27-03-2020 23:59</p>

                        <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-auto d-flex">
        <a class="btn btn-red mb-5 w-75 mx-auto" href="#">Delete account</a>
    </div>
</div>


</div>
<?php
include('../templates/common/footer.php');
?>

<script src="../scripts/collapseAnimation.js"></script>