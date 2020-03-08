<!DOCTYPE html>
<html>

<head>
    <title>BidMonkeys</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo.png" type="image/x-icon"/>
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/layout.css" rel="stylesheet">
    <link href="../css/responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body>
    <div class="content">
        <nav id="menu">
            <!-- just for the hamburguer menu in responsive layout -->
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
                    if ($displaySearch)
                        include('../templates/common/search.php');
                    ?>
                </li>
                <?php
                if ($logedin) { ?>
                    <li class="alignCenter">
                        <a href="#">
                        <img src="../images/bell.jpg" height="40" alt="Notifications">
                        </a>
                        <a href="#">
                            <h4>Add Auction</h4>
                        </a>
                        <div class="dropdown">
                            <h4>Name Name</h4>
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
                <?php } else { ?>
                    <li>
                        <form action="#">
                            <button id="create_auction_btn" type="submit"><h4>Add Auction</h4></button>
                        </form>
                        <form action="signup.php">
                            <button value="login" type="submit"><h4>Login</h4></button>
                        </form>
                        <form action="signup.php">
                            <button value="signup" type="submit"><h4>Register</h4></button>
                        </form>
                    </li>
                <?php } ?>
            </ul>
        </nav>