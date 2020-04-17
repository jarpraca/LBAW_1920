@extends('layouts.app')

@section('title', 'Homepage')

@section('content')

<div class="bg-white pt-4">
    <div class="text-left mainBody">
        <h2 class="mt-3">Trending</h2>
        <div class="d-flex flex-wrap text-left justify-content-around">
            <div class="card auct-card mt-4">
                <img class="card-img-top" src="{{asset('assets/monkey.jpg')}}" alt="Card image cap">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title font-weight-bold">Macaco da Nazaré</h5>
                    <div class="d-flex flex-row justify-content-between mr-2">
                        <p class="card-text">500€</p>
                        <p class="card-text">2 anos</p>
                    </div>

                    <p class="card-text smallFont">Ending time </p>
                    <p>30-03-2020 23:59</p>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <i class="far fa-eye fa-2x colorGrey"></i>
                        <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                    </div>
                </div>
            </div>
            <div class="card auct-card mt-4">
                <img class="card-img-top" src="{{asset('assets/lion.jfif')}}" alt="Card image cap">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title font-weight-bold">Macaco da Nazaré 2</h5>
                    <div class="d-flex flex-row justify-content-between mr-2">
                        <p class="card-text">500€</p>
                        <p class="card-text">2 anos</p>
                    </div>

                    <p class="card-text smallFont">Ending time </p>
                    <p>30-03-2020 23:59</p>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <i class="far fa-eye fa-2x colorGrey"></i>
                        <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                    </div>
                </div>
            </div>
            <div class="card auct-card mt-4">
                <img class="card-img-top" src="{{asset('assets/monkey.jpg')}}" alt="Card image cap">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title font-weight-bold">Macaco da Nazaré 3</h5>
                    <div class="d-flex flex-row justify-content-between mr-2">
                        <p class="card-text">500€</p>
                        <p class="card-text">2 anos</p>
                    </div>

                    <p class="card-text smallFont">Ending time </p>
                    <p>30-03-2020 23:59</p>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <i class="far fa-eye fa-2x colorGrey"></i>
                        <a href="viewAuctionGuest.php" class="btn btn-green align-self-end">View Auction</a>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-3">Categories</h2>
        <div class="d-flex flex-row flex-wrap mt-4 rounded overflow-hidden">
            <a class="card text-white border-0 rounded-0 category-card" href="search.php">
                <img class="card-img rounded-0" src="{{asset('assets/mammals.jpg')}}" alt="Card image">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Mammals</h3>
                </div>
            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="search.php">
                <img class="card-img rounded-0" src="{{asset('assets/insects.jpg')}}" alt="Card image">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Insects</h3>
                </div>
            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="search.php">
                <img class="card-img rounded-0" src="{{asset('assets/reptiles.jpg')}}" alt="Card image">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Reptiles</h3>
                </div>
            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="search.php">
                <img class="card-img rounded-0" src="{{asset('assets/birds.png')}}" alt="Card image">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Birds</h3>
                </div>
            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="search.php">
                <img class="card-img rounded-0" src="{{asset('assets/fishes.jpeg')}}" alt="Card image">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Fishes</h3>
                </div>

            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="search.php">
                <img class="card-img rounded-0" src="{{asset('assets/amphibians.jpg')}}" alt="Card image">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Amphibians</h3>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection