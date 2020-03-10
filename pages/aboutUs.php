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
$displaySearch = false;

if (isset($_SESSION['user']))
    $loggedin = true;

include('../templates/common/header.php');
?>
<div id="aboutUs_bg" class="mainBody">

    <div class="text-left" id="aboutUs_main">
        <h1 class="mt-3">About us </h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et pulvinar dui, tincidunt faucibus tortor. Curabitur feugiat quam arcu. Nulla malesuada quis neque sed ultrices. Vivamus non purus et ipsum ultricies ornare sit amet eget erat. Nam quam ex, sodales sit amet dapibus pellentesque, suscipit quis eros. Nulla vestibulum dapibus urna, non fringilla magna faucibus vel. Nam pharetra sapien nisl, ut rutrum lacus pulvinar lacinia. Phasellus justo lorem, venenatis id libero a, varius vehicula arcu. Mauris eget urna urna. Etiam quam nulla, ultrices non est ac, laoreet blandit nisi. Morbi quis leo nec tellus consectetur consequat ut et massa. Nam laoreet ipsum quis finibus fermentum. Praesent sit amet nisl luctus, sollicitudin nulla sed, mattis elit.</p>

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