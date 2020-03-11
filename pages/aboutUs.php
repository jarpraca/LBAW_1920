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
$displaySearch = false;

if (isset($_SESSION['user']))
    $loggedin = true;

include('../templates/common/header.php');
?>
<div id="aboutUs_bg" class="mainBody">

    <div class="text-left" id="aboutUs_main">
        <h1 class="mt-3">About us </h2>
        <p>Our company attempts to provide with the most intuitive and convinient place to take place in wildlife auctions. We hope to be able to bring you a diversified selection of different animals from all over the world, so that you can find your perfect companion.</p>

    </div>


    <div id="aboutUs_photos">
        <div class="d-flex flex-row mt-5">
            <div class="card text-white border-0 category-card">
                <img class="card-img" src="../images/mammals.jpg" alt="Card image">
            </div>
            <div class="card text-white border-0 category-card">
                <img class="card-img" src="../images/insects.jpg" alt="Card image">
            </div>
            <div class="card text-white border-0 category-card">
                <img class="card-img" src="../images/reptiles.jpg" alt="Card image">
            </div>
            <div class="card text-white border-0 category-card">
                <img class="card-img" src="../images/birds.png" alt="Card image">
            </div>
            <div class="card text-white border-0 category-card">
                <img class="card-img" src="../images/fishes.jpeg" alt="Card image">
            </div>
        </div>
    </div>

    <div class="text-left" id="aboutUs_testimonials">

        <h1 class="mt-3">Testimonials</h2>

        <!-- Section: Testimonials v.1 -->
        <section class="text-center my-5 p-1">


            <!-- Grid row -->
            <div class="row">

                <!--Grid column-->
                <div class="col-lg-4 col-md-12 mb-lg-0 mb-4">
                    <!--Card-->
                    <div class="card testimonial-card pt-4">
                        <!--Background color-->
                        <div class="card-up info-color"></div>
                        <!--Avatar-->
                        <div class="avatar mx-auto white">
                            <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(9).jpg" class="rounded-circle img-fluid">
                        </div>
                        <div class="card-body">
                            <!--Name-->
                            <h4 class="font-weight-bold mb-4">John Doe</h4>
                            <hr>
                            <!--Quotation-->
                            <p class="dark-grey-text mt-4"><i class="fas fa-quote-left pr-2"></i>Lorem ipsum dolor sit amet eos
                                adipisci, consectetur adipisicing elit.</p>
                        </div>
                    </div>
                    <!--Card-->
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
                    <!--Card-->
                    <div class="card testimonial-card pt-4">
                        <!--Background color-->
                        <div class="card-up blue-gradient">
                        </div>
                        <!--Avatar-->
                        <div class="avatar mx-auto white">
                            <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(20).jpg" class="rounded-circle img-fluid">
                        </div>
                        <div class="card-body">
                            <!--Name-->
                            <h4 class="font-weight-bold mb-4">Anna Aston</h4>
                            <hr>
                            <!--Quotation-->
                            <p class="dark-grey-text mt-4"><i class="fas fa-quote-left pr-2"></i>Neque cupiditate assumenda in
                                maiores repudiandae mollitia architecto.</p>
                        </div>
                    </div>
                    <!--Card-->
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-4 col-md-6">
                    <!--Card-->
                    <div class="card testimonial-card pt-4">
                        <!--Background color-->
                        <div class="card-up indigo"></div>
                        <!--Avatar-->
                        <div class="avatar mx-auto white">
                            <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(10).jpg" class="rounded-circle img-fluid">
                        </div>
                        <div class="card-body">
                            <!--Name-->
                            <h4 class="font-weight-bold mb-4">Maria Kate</h4>
                            <hr>
                            <!--Quotation-->
                            <p class="dark-grey-text mt-4"><i class="fas fa-quote-left pr-2"></i>Delectus impedit saepe officiis
                                ab aliquam repellat rem unde ducimus.</p>
                        </div>
                    </div>
                    <!--Card-->
                </div>
                <!--Grid column-->

            </div>
            <!-- Grid row -->

        </section>
        <!-- Section: Testimonials v.1 -->


    </div>

</div>

<?php
include('../templates/common/footer.php');
?>

<script src="../scripts/signupAnimation.js"></script>