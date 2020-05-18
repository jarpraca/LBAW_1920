@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="bg-white pt-4">
    <div class="mainBody">
        <h1 class="mt-3 colorGreen">Profile</h1>
        <div class="d-flex flex-wrap align-items-center">

            <div class="mx-auto image-container">
                <img class="profile_img" src="{{url($picture_name)}}" alt="{{$picture_name}}">
            </div>
            <div class="w-50 align-items-between image-container">

                <p class="mb-0">Name</p>
                <p class="font-weight-bold mt-0">{{$profile->name}}</p>

                <p class="mb-0">E-mail</p>
                <p class="font-weight-bold mt-0">{{$profile->email}}</p>

                <div class="no-print" id="profile_edit">
                    <a class="colorGreen text-decoration-underline mx-auto w-75" href="{{ route('edit_profile', ['id' => Auth::user()->id]) }}">Edit</u></a>
                </div>
            </div>
        </div>

        @if($bidding != null)
        <div class="collapsible mt-5 mb-4">
            <button class="collapsible_btn ml-0 w-100 py-2 text-left" data-toggle="collapse" data-target="#ongoing" aria-expanded="false" aria-controls="ongoing">
                <div class="d-flex flex-row justify-content-between">
                    <h5 class="font-weight-bold">Bidding</h5>
                    <i class="fas fa-chevron-down mr-2 p-0"></i>
                    <i class="fas fa-chevron-up mr-2 p-0"></i>
                </div>
            </button>

            <div class="collapse" id="ongoing" class="bgColorGrey">
                @if (sizeof($bidding) == 0)
                <p class="ml-3 mt-3">You are not bidding on any auction</p>
                @else
                <div class="d-flex flex-wrap text-left justify-flex-start">
                    @each('partials.card', $bidding, 'auction')
                </div>
                @endif
            </div>
        </div>
        @endif

        @if($my_auctions != [] && $my_auctions != null)
        <div class="collapsible mt-2 mb-4">
            <button class="collapsible_btn ml-0 w-100 py-2 text-left" data-toggle="collapse" data-target="#my_auctions" aria-expanded="false" aria-controls="my_auctions">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <h5 class="font-weight-bold">My Auctions</h5>
                    <i class="fas fa-chevron-down mr-2 p-0"></i>
                    <i class="fas fa-chevron-up mr-2 p-0"></i>
                </div>
            </button>

            <div class="collapse" id="my_auctions" class="bgColorGrey">
                @if(sizeof($my_auctions) == 0)
                <p class="ml-3 mt-3">You still haven't created any auctions </p>
                @else
                <div class="d-flex flex-wrap text-left justify-flex-start">
                    @each('partials.card', $my_auctions, 'auction')
                </div>
                @endif
            </div>
        </div>
        @endif

        @if($watchlist != null)
        <div class="collapsible mt-2 mb-4">
            <button class="collapsible_btn ml-0 w-100 py-2 text-left" data-toggle="collapse" data-target="#watchlist" aria-expanded="false" aria-controls="watchlist">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <h5 class="font-weight-bold">Watchlist</h5>
                    <i class="fas fa-chevron-down mr-2 p-0"></i>
                    <i class="fas fa-chevron-up mr-2 p-0"></i>
                </div>
            </button>

            <div class="collapse" id="watchlist" class="bgColorGrey">
                @if (sizeof($watchlist) == 0)
                <p class="ml-3 mt-3">You still haven't added any auctions to your watchlist </p>
                @else
                <div class="d-flex flex-wrap text-left justify-flex-start">
                    @each('partials.card', $watchlist, 'auction')
                </div>
                @endif
            </div>
        </div>
        @endif

        @if($purchase_history != null)
        <div class="collapsible mt-2 mb-4">
            <button class="collapsible_btn ml-0 w-100 py-2 text-left" data-toggle="collapse" data-target="#purchase_history" aria-expanded="false" aria-controls="purchase_history">
                <div class="d-flex flex-row justify-content-between">
                    <h5 class="font-weight-bold">Purchase History</h5>
                    <i class="fas fa-chevron-down mr-2 p-0"></i>
                    <i class="fas fa-chevron-up mr-2 p-0"></i>
                </div>
            </button>

            <div class="collapse" id="purchase_history" class="bgColorGrey">
                @if(sizeof($purchase_history) == 0)
                <p class="ml-3 mt-3">You still haven't won any auctions </p>
                @else
                <div class="d-flex flex-wrap text-left justify-flex-start">
                    @each('partials.card', $purchase_history, 'auction')
                </div>
                @endif
            </div>
        </div>
        @endif

        @if($didnt_win != null)
        <div class="collapsible mt-2 mb-4">
            <button class="collapsible_btn ml-0 w-100 py-2 text-left" data-toggle="collapse" data-target="#didnt_win" aria-expanded="false" aria-controls="didnt_win">
                <div class="d-flex flex-row justify-content-between">
                    <h5 class="font-weight-bold">Didn't Win</h5>
                    <i class="fas fa-chevron-down mr-2 p-0"></i>
                    <i class="fas fa-chevron-up mr-2 p-0"></i>
                </div>
            </button>

            <div class="collapse" id="didnt_win" class="bgColorGrey">
                @if(sizeof($didnt_win) == 0)
                <p class="ml-3 mt-3">You haven't bidded on an auction yet</p>
                @else
                <div class="d-flex flex-wrap text-left justify-flex-start">
                    @each('partials.card', $didnt_win, 'auction')
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="no-print mx-auto d-flex">
            <form class="btn w-75 mx-auto" method="POST" action="{{ route('delete_profile', ['id' => Auth::user()->id]) }}">
                {{ csrf_field() }}
                {{method_field('DELETE')}}
                <button class="btn btn-red py-2 mb-5 w-75 mx-auto" type="submit">Delete Account</button>
            </form>
        </div>
    </div>
</div>

</div>
@endsection