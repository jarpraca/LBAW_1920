@extends('layouts.app')

@section('title', 'Help Section')

@section('content')


<meta property="og:title" content="BidMonkeys- Your animal auction website" />
<meta property="og:description" content="Here's our help section with all the intel you need!" />
<meta property="og:image" content="{{asset('assets/logo.png')}}" />
<meta property="og:locale" content="en_GB" />

<div class="bg-white pt-4">
    <div class="pb-5 text-left mainBody">
        <h2 class="mt-3 text-dark">FAQs</h2>
        <div class="collapsible mt-5 mb-4">
            <button class="collapsible_btn ml-0 w-100 py-2 text-left d-flex flex-row justify-content-between align-items-center" data-toggle="collapse" data-target="#canSell" aria-expanded="false" aria-controls="canSell">
                <span class="h5 font-weight-bold">Who can sell items on the website? </span>
                <i class="fas fa-chevron-down mr-2 p-0"></i>
                <i class="fas fa-chevron-up mr-2 p-0"></i>
            </button>
            <div class="collapse bgColorGrey" id="canSell">
                <p class="ml-3 mt-3">Anyone</p>
            </div>
        </div>
        <div class="collapsible mt-5 mb-4">
            <button class="collapsible_btn ml-0 w-100 py-2 text-left d-flex flex-row justify-content-between align-items-center" data-toggle="collapse" data-target="#receiveProduct" aria-expanded="false" aria-controls="receiveProduct">
                <span class="h5 font-weight-bold">A seller never delivered an animal what can I do? </span>
                <i class="fas fa-chevron-down mr-2 p-0"></i>
                <i class="fas fa-chevron-up mr-2 p-0"></i>
            </button>
            <div class="collapse bgColorGrey" id="receiveProduct">
                <p class="ml-3 mt-3">Please contact us via email with more details</p>
            </div>
        </div>
        <div class="collapsible mt-5 mb-4">
            <button class="collapsible_btn ml-0 w-100 py-2 text-left d-flex flex-row justify-content-between align-items-center" data-toggle="collapse" data-target="#canBuy" aria-expanded="false" aria-controls="canBuy">
                <span class="h5 font-weight-bold">Do I have to create an account in order to buy? </span>
                <i class="fas fa-chevron-down mr-2 p-0"></i>
                <i class="fas fa-chevron-up mr-2 p-0"></i>
            </button>
            <div class="collapse bgColorGrey" id="canBuy">
                <p class="ml-3 mt-3">Yes, we need basic information about you so that you can buy an animal</p>
            </div>
        </div>


        <h2 class="my-3 text-dark">Contacts</h2>
            <p>General Email: geral@bidmonkey.com</p>
            <p>Support Email: bidmonkey@gmail.com</p>
            <p>Phone Number: + 351 912 345 678</p>
    </div>
</div>
@endsection