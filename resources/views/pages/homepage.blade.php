@extends('layouts.app')

@section('title', 'Homepage')

@section('content')

<div class="bg-white pt-4">
    <div class="pb-5 text-left mainBody">
        <h2 class="mt-3 text-dark">Trending</h2>
        <div class="d-flex flex-wrap text-left justify-content-around">
            @each('partials.card', $auctions, 'auction')
        </div>

        <h2 class="mt-3 text-dark">Categories</h2>
        <div class="d-flex flex-row flex-wrap mt-4 rounded overflow-hidden">
            <a class="card text-white border-0 rounded-0 category-card" href="auctions/search?mammals=">
                <img class="card-img rounded-0" src="{{asset('assets/mammals.jpg')}}" alt="Card image">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Mammals</h3>
                </div>
            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="auctions/search?insects=">
                <img class="card-img rounded-0" src="{{asset('assets/insects.jpg')}}" alt="Card image">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Insects</h3>
                </div>
            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="auctions/search?reptiles=">
                <img class="card-img rounded-0" src="{{asset('assets/reptiles.jpg')}}" alt="Card image">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Reptiles</h3>
                </div>
            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="auctions/search?birds=">
                <img class="card-img rounded-0" src="{{asset('assets/birds.png')}}" alt="Card image">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Birds</h3>
                </div>
            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="auctions/search?fishes=">
                <img class="card-img rounded-0" src="{{asset('assets/fishes.jpeg')}}" alt="Card image">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Fishes</h3>
                </div>
            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="auctions/search?amphibians=">
                <img class="card-img rounded-0" src="{{asset('assets/amphibians.jpg')}}" alt="Card image">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Amphibians</h3>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection