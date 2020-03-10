<!DOCTYPE html>
<html>

<head>
    <title>BidMonkeys</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo.png" type="image/x-icon" />
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/layout.css" rel="stylesheet">
    <link href="../css/responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body>
        <!-- <nav id="menu">
            <input type="checkbox" id="hamburger">
            <label class="hamburger" for="hamburger"></label>
            <ul>
                <li class="alignCenter">
                    <img src="../images/logo.png" height="50" alt="Logo">
                    <a href="../pages/homepage.php" class="title">
                        <h1 class="title">BidMonkeys</h1>
                    </a>
                </li>
                <li>
                    <?php
                    // if ($displaySearch)
                    //     include('../templates/common/search.php');
                    ?>
                </li>
                <?php
                // if ($logedin) { 
                ?>
                    <li class="alignCenter">
                        <a href="#">
                            <img src="../images/bell.jpg" height="40" alt="Notifications">
                        </a>
                        <a href="#">
                            <h5>Add Auction</h5>
                        </a>
                        <div class="dropdown">
                            <h5>Name Name</h5>
                            <div class="dropdown-content">
                                <a href="#">
                                    <p>My Profile</p>
                                </a>
                                <a href="#">
                                    <p>Logout</p>
                                </a>
                            </div>
                        </div>
                    </li>
                <?php
                // } else { 
                ?>
                    <li class="alignCenter ">
                        <a href="#" class="btn btn-green">
                            <h5>Add Auction</h5>
                        </a>
                        <a href="login.php">
                            <h5>Sign In</h5>
                        </a>
                        <a href="register.php">
                            <h5>Sign Up</h5>
                        </a>
                    </li>
                <?php
                // } 
                ?>
            </ul>
        </nav> -->
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bgColorGreen">
            <a class="navbar-brand" href="homepage.php">
                <img src="../images/logo.png" width="50" alt="Logo">
                BidMonkeys
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Category
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Mammals</a>
                            <a class="dropdown-item" href="#">Insects</a>
                            <a class="dropdown-item" href="#">Reptiles</a>
                            <a class="dropdown-item" href="#">Birds</a>
                            <a class="dropdown-item" href="#">Fishes</a>
                            <a class="dropdown-item" href="#">Amphibians</a>
                        </div>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-green2 my-2 my-sm-0" type="submit">Search</button>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn border-white" href="createAuction.php">+ Add Auction</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn" href="signup.php">Sign In</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div>