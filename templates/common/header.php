<!DOCTYPE html>
<html>

<head>
    <title>BidMonkeys</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <link href="layout.css" rel="stylesheet">
    <link href="responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
</head>

<body>
    <div class="content">
        <nav id="menu">
            <!-- just for the hamburguer menu in responsive layout -->
            <input type="checkbox" id="hamburger">
            <label class="hamburger" for="hamburger"></label>
            <ul>
                <li class="alignCenter">
                    <img src="images/logo.png" height="50" alt="Logo">
                    <a href="homepage.php" class="title">
                        <h1 class="title">BidMonkeys</h1>
                    </a>
                </li>
                <li>
                    <?php
                    if ($displaySearch)
                        include('templates/common/search.php');
                    ?>
                </li>
                <?php
                if ($logedin) { ?>
                    <li class="alignCenter">
                        <a href="#">
                        <img src="images/bell.jpg" height="40" alt="Notifications">
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
                        <a href="#">
                            <h4>Add Auction</h4>
                        </a>
                        <a href="login.php">
                            <h4>Login</h4>
                        </a>
                        <a href="register.php">
                            <h4>Register</h4>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>