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
<div class="mainBody" id="profile">
    <h2 class="colorGreen">Profile</h2>
    <div id="profile_top">
        <div id="profile_img">
            <img src="../images/profilePicture.jpg">
        </div>
        <div id="profile_info">
            <div id="profile_name">
                <label class="profile_info_title">Name</label>
                <label class="profile_info_content">John Doe</label>
            </div>
            <div id="profile_email">
                <label class="profile_info_title">E-mail</label>
                <label class="profile_info_content">something@fe.up.pt</label>
            </div>
            <div id="profile_edit">
                <a class="btn btn-green mx-auto w-75" href="editProfile.php">Edit Information</a>
            </div>
        </div>
    </div>

    <div class="collapsible">
        <button type="button" class="collapsible_btn btn btn-green w-100 text-white py-3 text-left">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <span>Purchase History</span>
                <i class=" fas fa-chevron-down mr-2 p-0  "></i>
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

    <div class="collapsible">
        <button type="button" class="collapsible_btn btn btn-green w-100 text-white py-3 text-left">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <span>My Auctions</span>
                <i class=" fas fa-chevron-down mr-2 p-0  "></i>
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

    <div class="collapsible">
        <button type="button" class="collapsible_btn btn btn-green w-100 text-white py-3 text-left">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <span>Ongoing</span>
                <i class=" fas fa-chevron-down mr-2 p-0  "></i>
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

        <div class="collapsible">
            <button type="button" class="collapsible_btn btn btn-green w-100 text-white py-3 text-left">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <span>Watchlist</span>
                    <i class=" fas fa-chevron-down mr-2 p-0  "></i>
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
    </div>

    <a id="delete_acc_btn" class="btn btn-red" href="#">Delete account</a>

</div>
<?php
include('../templates/common/footer.php');
?>

<script src="../scripts/collapseAnimation.js"></script>