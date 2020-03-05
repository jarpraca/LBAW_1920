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
        <div class="auction">
            <img width="100%" src="./images/profilePicture.jpg">
            <p>Macaco da Nazaré</p>
            <p>500€</p>
            <p>2anos</p>
        </div>
        <div class="auction mx-5">
            <img width="100%" src="./images/profilePicture.jpg">
            <p>Macaco da Nazaré 2</p>
            <p>500€</p>
            <p>2anos</p>
        </div>
        <div class="auction">
            <img width="100%" src="./images/profilePicture.jpg">
            <p>Macaco da Nazaré 3</p>
            <p>500€</p>
            <p>2anos</p>
        </div>
    </div>

    <div class="d-flex flex-row mt-5">
        <div class="border border-dark container">
            <img width="100%" src="./images/profilePicture.jpg">
            <p class="overlay">Category 1</p>
        </div>
        <div class="border border-dark container">
            <img width="100%" src="./images/profilePicture.jpg">
            <p class="overlay">Category 2</p>

        </div>
        <div class="border border-dark container">
            <img width="100%" src="./images/profilePicture.jpg">
            <p class="overlay">Category 3</p>

        </div>
        <div class="border border-dark container">
            <img width="100%" src="./images/profilePicture.jpg">
            <p class="overlay">Category 4</p>
        </div>
    </div>
    <div class="d-flex flex-row mb-5">
        <div class="border border-dark container">
            <img width="100%" src="./images/profilePicture.jpg">
            <p class="overlay">Category 5</p>
        </div>
        <div class="border border-dark container">
            <img width="100%" src="./images/profilePicture.jpg">
            <p class="overlay">Category 6</p>

        </div>
        <div class="border border-dark container">
            <img width="100%" src="./images/profilePicture.jpg">
            <p class="overlay">Category 7</p>

        </div>
        <div class="border border-dark container">
            <img width="100%" src="./images/profilePicture.jpg">
            <p class="overlay">Category 8</p>
        </div>
    </div>
</div>
<?php
include('templates/common/footer.php');
?>