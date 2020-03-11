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
<section class="mainBody">

    <div class="bgColorGrey">

        <form class="navbar-search form-inline pt-5 mx-auto">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-green2 my-2 my-sm-0" type="submit">Search</button>
        </form>

        <div class="d-flex flex-wrap">
            <div class="mx-auto">
                <p class="justify-content-between">
                    <a class="btn btn-outline-green mx-2 mt-3" data-toggle="collapse" href="#categories" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Category
                    </a>
                    <a class="btn btn-outline-green mx-2 mt-3" data-toggle="collapse" href="#colors" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Color
                    </a>
                    <a class="btn btn-outline-green mx-2 mt-3" data-toggle="collapse" href="#price" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Price
                    </a>
                    <a class="btn btn-outline-green mx-2 mt-3" data-toggle="collapse" href="#devStage" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Dev. Stage
                    </a>
                    <a class="btn btn-outline-green mx-2 mt-3" data-toggle="collapse" href="#skills" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Skills
                    </a>
                </p>
                <div class="collapse" id="categories">
                    <div class="card card-body">
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class="col-6 col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Mammals
                                    </label>
                                </div>
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Insects
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Reptiles
                                    </label>
                                </div>
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Birds
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Fishes
                                    </label>
                                </div>
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Amphibians
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="collapse" id="colors">
                    <div class="card card-body">
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class="col-6 col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Blue
                                    </label>
                                </div>
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Green
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Brown
                                    </label>
                                </div>
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label" for="gridCheck">
                                        Red
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Black
                                    </label>
                                </div>
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        White
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Yellow
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse" id="price">
                    <div class="card card-body">
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class="col col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        < 100€ </label> </div> <div class="form-check row">
                                            <input class="form-check-input" type="checkbox" id="gridCheck">
                                            <label class="form-check-label font-size" for="gridCheck">
                                                101-300€
                                            </label>
                                </div>
                            </div>
                            <div class="col col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        301 - 500 €
                                    </label>
                                </div>
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        501 - 700 €
                                    </label>
                                </div>
                            </div>
                            <div class="col col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        701-900€
                                    </label>
                                </div>
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        > 900€
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse" id="devStage">
                    <div class="card card-body">
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class="col-6 col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Baby
                                    </label>
                                </div>
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Child
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Teen
                                    </label>
                                </div>
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Adult
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Elderly
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse" id="skills">
                    <div class="card card-body">
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class="col-6 col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Climbs
                                    </label>
                                </div>
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Jumps
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Talks
                                    </label>
                                </div>
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Skates
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Olfaction
                                    </label>
                                </div>
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Moonlight Navigation
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Echolocation
                                    </label>
                                </div>
                                <div class="form-check row">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label font-size" for="gridCheck">
                                        Acrobatics
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="d-flex flex-wrap text-left justify-content-around">
        <div class="card mt-4">
            <img class="card-img-top" src="../images/lion.jfif" alt="Card image cap">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Macaco da Nazaré</h5>
                <p class="card-text">700€</p>
                <p class="card-text">5 anos</p>
                <p class="card-text">Ending time: 30-03-2020 23:59</p>
                <div class="d-flex flex-row justify-content-between">
                    <i class="fas fa-eye fa-2x"></i>
                    <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <img class="card-img-top" src="../images/fishes.jpeg" alt="Card image cap">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Macaco da Nazaré 2</h5>
                <p class="card-text">500€</p>
                <p class="card-text">2 anos</p>
                <p class="card-text">Ending time: 22-03-2020 23:59</p>
                <div class="d-flex flex-row justify-content-between">
                    <i class="fas fa-eye fa-2x"></i>
                    <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <img class="card-img-top" src="../images/insects.jpg" alt="Card image cap">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Macaco da Nazaré 3</h5>
                <p class="card-text">500€</p>
                <p class="card-text">2 anos</p>
                <p class="card-text">Ending time: 30-03-2020 23:59</p>
                <div class="d-flex flex-row justify-content-between">
                    <i class="fas fa-eye fa-2x"></i>
                    <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap text-left justify-content-around">
        <div class="card mt-4">
            <img class="card-img-top" src="../images/animal3.jfif" alt="Card image cap">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Macaco da Nazaré</h5>
                <p class="card-text">500€</p>
                <p class="card-text">2 anos</p>
                <p class="card-text">Ending time: 30-03-2020 23:59</p>
                <div class="d-flex flex-row justify-content-between">
                    <i class="fas fa-eye fa-2x"></i>
                    <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <img class="card-img-top" src="../images/monkey.jpg" alt="Card image cap">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Macaco da Nazaré 2</h5>
                <p class="card-text">800€</p>
                <p class="card-text">6 meses</p>
                <p class="card-text">Ending time: 18-03-2020 23:59</p>
                <div class="d-flex flex-row justify-content-between">
                    <i class="fas fa-eye fa-2x"></i>
                    <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <img class="card-img-top" src="../images/animal2.jfif" alt="Card image cap">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Macaco da Nazaré 3</h5>
                <p class="card-text">900€</p>
                <p class="card-text">7 anos</p>
                <p class="card-text">Ending time: 27-03-2020 23:59</p>
                <div class="d-flex flex-row justify-content-between">
                    <i class="fas fa-eye fa-2x"></i>
                    <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                </div>
            </div>
        </div>
    </div>

</section>
<?php
include('../templates/common/footer.php');
?>