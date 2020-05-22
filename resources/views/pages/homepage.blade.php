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
            <a class="card text-white border-0 rounded-0 category-card" href="auctions/search?search=&mammals=on&min_price=&max_price=">
                <img class="card-img rounded-0" src="{{asset('assets/mammals.jpg')}}" alt="Mammals Category">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Mammals</h3>
                </div>
            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="auctions/search?search=&insects=on&min_price=&max_price=">
                <img class="card-img rounded-0" src="{{asset('assets/insects.jpg')}}" alt="Insects Category">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Insects</h3>
                </div>
            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="auctions/search?search=&reptiles=on&min_price=&max_price=">
                <img class="card-img rounded-0" src="{{asset('assets/reptiles.jpg')}}" alt="Reptiles Category">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Reptiles</h3>
                </div>
            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="auctions/search?search=&birds=on&min_price=&max_price=">
                <img class="card-img rounded-0" src="{{asset('assets/birds.png')}}" alt="Birds Category">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Birds</h3>
                </div>
            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="auctions/search?search=&fishes=on&min_price=&max_price=">
                <img class="card-img rounded-0" src="{{asset('assets/fishes.jpeg')}}" alt="Fishes Category">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Fishes</h3>
                </div>
            </a>
            <a class="card text-white border-0 rounded-0 category-card" href="auctions/search?search=&amphibians=on&min_price=&max_price=">
                <img class="card-img rounded-0" src="{{asset('assets/amphibians.jpg')}}" alt="Amphibians Category">
                <div class="card-img-overlay d-flex justify-content-center align-items-center">
                    <h3 class="card-title text-center text-shadow">Amphibians</h3>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection