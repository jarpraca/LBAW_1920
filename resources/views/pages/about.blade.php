@extends('layouts.app')

@section('title', 'About Us')

@section('content')

<div id="aboutUs_bg" class="bg-white pt-4">

    <div class="text-left w-50 mx-auto" id="aboutUs_main">
        <h1 class="mt-3 mb-2 text-dark">About us</h1>
            <p class="text-box" >Our company attempts to provide with the most intuitive and convinient place to take place in wildlife auctions. We hope to be able to bring you a diversified selection of different animals from all over the world, so that you can find your perfect companion. It is also one of our main priorities to ensure that every animal is captured and taken care of under ethical circuntances. We value the connection between human and animal and our number one objective is to ensure that our costumers will be able to live out their dreams with the perfect animal compaion by their side! Best of Luck in your bidding.</p>
    </div>

    <div id="aboutUs_photos">
        <div class="d-flex flex-row mt-5">
            <div class="text-white border-0 w-25">
                <img class="card-img" src="{{asset('assets/mammals.jpg')}}" alt="Mammal image">
            </div>
            <div class="text-white border-0 w-25">
                <img class="card-img" src="{{asset('assets/insects.jpg')}}" alt="Insect image">
            </div>
            <div class="text-white border-0 w-25">
                <img class="card-img" src="{{asset('assets/reptiles.jpg')}}" alt="Reptil image">
            </div>
            <div class="text-white border-0 w-25">
                <img class="card-img" src="{{asset('assets/birds.png')}}" alt="Bird image">
            </div>
        </div>
    </div>

    <div class="text-left w-75 mx-auto" id="aboutUs_testimonials">
        <div class="pl-5">
            <h1 class="mt-5 ml-3 text-dark">Testimonials</h1>
        </div>
        <section class="text-center mt-3 mb-5 p-1">
            <div class="row mx-5">
                <div class="col-lg-4 col-md-12 mb-lg-0 mb-4">
                    <div class="testimonial-card pt-4">
                        <div class="card-up info-color"></div>
                        <div class="avatar mx-auto white">
                            <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(9).jpg" alt="John Doe's Photo" class="rounded-circle img-fluid">
                        </div>
                        <div class="card-body">
                            <h4 class="font-weight-bold mb-4">John Doe</h4>
                            <hr>
                            <p class="dark-grey-text mt-4"><i class="fas fa-quote-left pr-2"></i>Easiest bidding experience I have taken part in. Definitely reccomend.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
                    <div class="testimonial-card pt-4">
                        <div class="card-up blue-gradient">
                        </div>
                        <div class="avatar mx-auto white">
                            <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(20).jpg"  alt="Anna Aston's Photo"  class="rounded-circle img-fluid">
                        </div>
                        <div class="card-body">
                            <h4 class="font-weight-bold mb-4">Anna Aston</h4>
                            <hr>
                            <p class="dark-grey-text mt-4"><i class="fas fa-quote-left pr-2"></i>Got my little Albert here, it's been 6 years of monkeying around!</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card pt-4">
                        <div class="card-up indigo"></div>
                        <div class="avatar mx-auto white">
                            <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(10).jpg"  alt="Maria Kate's Photo" class="rounded-circle img-fluid">
                        </div>
                        <div class="card-body">
                            <h4 class="font-weight-bold mb-4">Maria Kate</h4>
                            <hr>
                            <p class="dark-grey-text mt-4"><i class="fas fa-quote-left pr-2"></i>This websites easy to use design helped improve my bussiness massively!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection