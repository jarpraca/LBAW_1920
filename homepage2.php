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

include('templates/common/header.php');
?>
<div class="text-left" id="homepage">
    <h2 class="mt-3">Welcome, </h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et pulvinar dui, tincidunt faucibus tortor. Curabitur feugiat quam arcu. Nulla malesuada quis neque sed ultrices. Vivamus non purus et ipsum ultricies ornare sit amet eget erat. Nam quam ex, sodales sit amet dapibus pellentesque, suscipit quis eros. Nulla vestibulum dapibus urna, non fringilla magna faucibus vel. Nam pharetra sapien nisl, ut rutrum lacus pulvinar lacinia. Phasellus justo lorem, venenatis id libero a, varius vehicula arcu. Mauris eget urna urna. Etiam quam nulla, ultrices non est ac, laoreet blandit nisi. Morbi quis leo nec tellus consectetur consequat ut et massa. Nam laoreet ipsum quis finibus fermentum. Praesent sit amet nisl luctus, sollicitudin nulla sed, mattis elit.</p>
    <div class="d-flex flex-row text-left">
        <div class="card">
            <img class="card-img-top" src="./images/profilePicture.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Macaco da Nazaré</h5>
                <p class="card-text">500€</p>
                <p class="card-text">2 anos</p>
                <a href="#" class="btn btn-green">Go somewhere</a>
            </div>
        </div>
        <div class="card mx-5">
            <img class="card-img-top" src="./images/profilePicture.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Macaco da Nazaré 2</h5>
                <p class="card-text">500€</p>
                <p class="card-text">2 anos</p>
                <a href="#" class="btn btn-outline-green">Go somewhere</a>
            </div>
        </div>
        <div class="card">
            <img class="card-img-top" src="./images/profilePicture.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Macaco da Nazaré 3</h5>
                <p class="card-text">500€</p>
                <p class="card-text">2 anos</p>
                <a href="#" class="btn btn-outline-green">Go somewhere</a>
            </div>
        </div>
    </div>

    <div class="d-flex flex-row mt-5">
        <div class="card text-white border-0">
            <img class="card-img" src="./images/profilePicture.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h5 class="card-title">Category 1</h5>
            </div>
        </div>
        <div class="card text-white border-0">
            <img class="card-img" src="./images/profilePicture.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h5 class="card-title">Category 2</h5>
            </div>
        </div>
        <div class="card text-white border-0">
            <img class="card-img" src="./images/profilePicture.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h5 class="card-title">Category 3</h5>
            </div>
        </div>
        <div class="card text-white border-0">
            <img class="card-img" src="./images/profilePicture.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h5 class="card-title">Category 4</h5>
            </div>
        </div>
    </div>
    <div class="d-flex flex-row mb-5">
        <div class="card text-white border-0">
            <img class="card-img" src="./images/profilePicture.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h5 class="card-title">Category 5</h5>
            </div>
        </div>
        <div class="card text-white border-0">
            <img class="card-img" src="./images/profilePicture.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h5 class="card-title">Category 6</h5>
            </div>
        </div>
        <div class="card text-white border-0">
            <img class="card-img" src="./images/profilePicture.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h5 class="card-title">Category 7</h5>
            </div>
        </div>
        <div class="card text-white border-0">
            <img class="card-img" src="./images/profilePicture.jpg" alt="Card image">
            <div class="card-img-overlay d-flex justify-content-center align-items-center">
                <h5 class="card-title">Category 8</h5>
            </div>
        </div>
    </div>
</div>
<?php
include('templates/common/footer.php');
?>