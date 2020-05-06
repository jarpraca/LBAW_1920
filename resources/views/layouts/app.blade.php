<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="{{asset('assets/logo.png')}}" type="image/x-icon" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/0d51041d85.js" crossorigin="anonymous"></script>

  <title>{{ config('app.name', 'BidMonkey') }}</title>

  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
  <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">

  <script type="text/javascript">
    // Fix for Firefox autofocus CSS bug
    // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
  </script>
  <script type="text/javascript" src={{ asset('js/app.js') }} defer> </script>
</head>

<body>
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bgColorGreen">
    <a class="navbar-brand" href="/homepage">
      <img src="{{asset('assets/logo.png')}}" width="50" alt="Logo">
      BidMonkey
    </a>
    <button class="navbar-toggler border-white" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Category
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="search.php">Mammals</a>
            <a class="dropdown-item" href="search.php">Insects</a>
            <a class="dropdown-item" href="search.php">Reptiles</a>
            <a class="dropdown-item" href="search.php">Birds</a>
            <a class="dropdown-item" href="search.php">Fishes</a>
            <a class="dropdown-item" href="search.php">Amphibians</a>
          </div>
        </li>
      </ul>
      <?php
      // if ($displaySearch) {
      ?>
      <form class="navbar-search form-inline my-2 my-lg-0" method="GET" action="{{ route('textSearch') }}">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
        <button type="submit" class="btn btn-green2 mt-2 mt-sm-0" >Search</button>
      </form>
      <?php
      // }
      ?>
      <ul class="navbar-nav align-items-center">
        @auth
        <li class="nav-item">
          <div class="btn btn-green mx-auto p-2 my-2 my-sm-0 popup" data-toggle="modal" data-target="#exampleModal">
            <img src="{{asset('assets/bell.png')}}" height="30" alt="Notifications">
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link btn btn-add-auction mx-sm-2 px-2 <?php //if ($createAuctionPage) { 
                                                              ?> btn-darkGreen <?php // } 
                                                              ?>" <?php // if (!$createAuctionPage) { 
                                                              ?> id="btn-add-auction" <?php // } 
                                                              ?> href="/auctions">+ Add Auction</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-center my-2 my-sm-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{Auth::user()->name}}
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('profiles', ['id' => Auth::id()]) }}">View Profile</a>
            @inject('admin', 'App\Admin')
            @if($admin::find(Auth::user()->id) != null)
            <a class="dropdown-item" href="{{ route('admin') }}">Admin Dashboard</a>
            @endif
            <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
          </div>
        </li>
        @endauth
        @guest
        <li class="nav-item">
          <a class="nav-link btn btn-add-auction mx-sm-2 px-2 <?php //if ($createAuctionPage) { 
                                                              ?> btn-darkGreen <?php // } 
                                                                                ?>" <?php // if (!$createAuctionPage) { 
                                                                                    ?> id="btn-add-auction" <?php // } 
                                                                                                            ?> href="/login">+ Add Auction</a>
        </li>

        <li class="nav-item">
          <a class="nav-link btn my-2 my-sm-0 px-2<?php //if ($signUpPage) { 
                                                  ?> btn-darkGreen <?php //} 
                                                                    ?>" href="/login">Sign In</a>
        </li>
        @endguest
      </ul>
    </div>
  </nav>

  <div>
    <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content mx-auto">
          <div class="modal-header">
            <h2 class="mt-3">Auction Name</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group ml-3 mr-3 mt-3">
              <p class="text-left">Payment Method</p>
              <select name="categories" class="outline-green form-control" required>
                <option value="0" selected hidden></option>
                <option value="1">Debit Card</option>
                <option value="2">Paypal</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    @yield('content')

  </div>
  <footer id="footer" class="navbar d-flex justify-content-between align-items-center w-100">
    <a class="mx-2 align-items-center">Copyright © 2020</a>
    <li class="d-flex flex-row align-items-center">
      <a class="nav-link" href="/about">
        About
      </a>
    </li>
  </footer>
</body>

</html>