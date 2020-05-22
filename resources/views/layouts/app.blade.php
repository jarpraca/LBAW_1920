<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id" content="766183794117-j9tk22ig7adjond13b5o532j60r33rr0.apps.googleusercontent.com">

    <link rel="icon" href="{{asset('assets/logo.png')}}" type="image/x-icon" />
    <link type="text/css" rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/0d51041d85.js" crossorigin="anonymous"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_PT/sdk.js#xfbml=1&version=v7.0&appId=261449561717437&autoLogAppEvents=1"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>


    <title>@yield('title') - {{ config('app.name', 'BidMonkey') }}</title>

    <link type="text/css" href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/print.css') }}" media="print" rel="stylesheet" />

    <script src="{{ asset('js/app.js') }}" defer> </script>
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bgColorGreen no-print">
        <a class="navbar-brand" href="/homepage">
            <img src="{{asset('assets/logo.png')}}" width="50" alt="Bid Monkey Logo">
            BidMonkey
        </a>
        <button class="navbar-toggler border-white" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-center" href="#" id="categoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Category
                    </a>
                    <div class="dropdown-menu" aria-labelledby="categoryDropdown">
                        <a class="dropdown-item" href="/auctions/search?search=&mammals=on&min_price=&max_price=">Mammals</a>
                        <a class="dropdown-item" href="/auctions/search?search=&insects=on&min_price=&max_price=">Insects</a>
                        <a class="dropdown-item" href="/auctions/search?search=&reptiles=on&min_price=&max_price=">Reptiles</a>
                        <a class="dropdown-item" href="/auctions/search?search=&birds=on&min_price=&max_price=">Birds</a>
                        <a class="dropdown-item" href="/auctions/search?search=&fishes=on&min_price=&max_price=">Fishes</a>
                        <a class="dropdown-item" href="/auctions/search?search=&amphibians=on&min_price=&max_price=">Amphibians</a>
                    </div>
                </li>
            </ul>
            @if(Route::currentRouteName() != 'search')
            <form class="navbar-search form-inline my-2 my-lg-0" method="GET" action="{{ route('search') }}">
                <label style="display:none" for="search"></label>
                <input class="form-control mr-sm-2" type="search" id="search" name="search" placeholder="Search" aria-label="Search">
                <button type="submit" class="btn btn-green2 mt-2 mt-sm-0">Search</button>
            </form>
            @endif
            <ul class="navbar-nav align-items-center">
                @auth
                <li class="nav-item">
                    <div class="btn btn-green mx-auto p-2 my-2 my-sm-0 popup" data-toggle="modal" data-target="#exampleModal">
                        <img src="{{asset('assets/bell.png')}}" height="30" alt="Notifications">
                    </div>
                </li>

                @inject('admin', 'App\Admin')
                @if($admin::find(Auth::user()->id) == null)
                <li class="nav-item">
                    <a class="nav-link btn mx-sm-2 px-2 {!! Route::currentRouteName() == 'create_auction' ? 'btn-darkGreen' : 'btn-add-auction' !!}" href="/auctions">+ Add Auction</a>
                </li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-center my-2 my-sm-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{Auth::user()->name}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('profiles', ['id' => Auth::id()]) }}">View Profile</a>
                        @if($admin::find(Auth::user()->id) != null)
                        <a class="dropdown-item" href="{{ route('admin') }}">Admin Dashboard</a>
                        @endif
                        <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
                    </div>
                </li>
                @endauth
                @guest
                <li class="nav-item">
                    <a class="nav-link btn mx-sm-2 px-2 btn-add-auction" href="/login">+ Add Auction</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link btn my-2 my-sm-0 px-2 {!! (Route::currentRouteName() == 'login' || Route::currentRouteName() == 'register') ? 'btn-darkGreen' : '' !!}" href="/login">Sign In</a>
                </li>
                @endguest
            </ul>
        </div>
    </nav>

    <div class="modal fade" id="exampleModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content mx-auto">
                <div class="modal-header">
                    <h2 class="mt-3">Auction Name</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ml-3 mr-3 mt-3">
                        <label class="text-left" for="pay_method">Payment Method</label>
                        <select id="pay_method" name="categories" class="outline-green form-control" required>
                            <option value="" selected hidden>Choose payment method</option>
                            <option value="1">Debit Card</option>
                            <option value="2">Paypal</option>
                        </select>
                    </div>

                    <div class="form-group ml-3 mr-3 mt-3">
                        <label class="text-left" for="ship_method">Shipping Method</label>
                        <select id="ship_method" name="categories" class="outline-green form-control" required>
                            <option value="" selected hidden>Choose shipping method</option>
                            <option value="1">Standard Mail</option>
                            <option value="2">Express Mail</option>
                            <option value="3">Urgent Mail</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <a id="method_button" class="btn btn-green2" data-dismiss="modal">Submit</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @yield('content')
    <footer id="footer" class="navbar d-flex justify-content-between align-items-center w-100 no-print">
        <a class="mx-2 align-items-center">Copyright © 2020</a>
        <div class="d-flex flex-row align-items-center">
            <a class="nav-link" href="/help">
                Help
            </a>
            <a class="nav-link" href="/about">
                About
            </a>
        </div>
    </footer>
</body>

</html>