@extends('layouts.app')

@section('title', 'View Auction')

@section('content')
<div class="bg-white pt-4">
    <div class="mainBody">
        <h1 class="mt-3 colorGreen">Profile</h1>
        <div class="d-flex flex-wrap align-items-center">

            <div class="mx-auto image-container">
                <img class="edit_profile_img" src="{{url($picture_name)}}" alt="{{$picture_name}}">
                <input id="image_upload" type="file" name="profile_photo" placeholder="Photo" required="" capture>

            </div>
            <div class="w-50 align-items-between image-container">

                <p class="mb-0">Name</p>
                <p class="font-weight-bold mt-0">{{$profile->name}}</p>

                <p class="mb-0">E-mail</p>
                <p class="font-weight-bold mt-0">{{$profile->email}}</p>

                <div id="profile_edit">
                    <a class="colorGreen text-decoration-underline mx-auto w-75" href="{{ route('edit_profile', ['id' => Auth::user()->id]) }}">Edit</u></a>
                </div>
            </div>
        </div>

        <div class="collapsible mt-5 mb-4">
            <button class="collapsible_btn w-100 py-2 text-left" data-toggle="collapse" data-target="#purchase_history" aria-expanded="false" aria-controls="purchase_history">
                <div class="d-flex flex-row justify-content-between">
                    <h5 class="font-weight-bold">Purchase History</h5>
                    <i class=" fas fa-chevron-down mr-2 p-0"></i>
                </div>
            </button>

            <div class="collapse" id="purchase_history" class="bgColorGrey">
                <?php
                if (sizeof($purchase_history) == 0) { ?>
                    <p>You still haven't won any auctions </p>
                <?php } else { ?>
                    <div class="d-flex flex-wrap text-left justify-flex-start">
                        @each('partials.card', $purchase_history, 'auction')
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="collapsible mt-2 mb-4">
            <button class="collapsible_btn w-100 py-2 text-left" data-toggle="collapse" data-target="#my_auctions" aria-expanded="false" aria-controls="my_auctions">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <h5 class="font-weight-bold">My Auctions</h5>
                    <i class=" fas fa-chevron-down mr-2 p-0"></i>
                </div>
            </button>

            <div class="collapse" id="my_auctions" class="bgColorGrey">
                <?php
                if (sizeof($my_auctions) == 0) { ?>
                    <p>You still haven't created any auctions </p>
                <?php } else { ?>
                    <div class="d-flex flex-wrap text-left justify-flex-start">
                        @each('partials.card', $my_auctions, 'auction')
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="collapsible mt-2 mb-4">
            <button class="collapsible_btn w-100 py-2 text-left" data-toggle="collapse" data-target="#ongoing" aria-expanded="false" aria-controls="ongoing">
                <div class="d-flex flex-row justify-content-between">
                    <h5 class="font-weight-bold">Ongoing Auctions</h5>
                    <i class=" fas fa-chevron-down mr-2 p-0"></i>
                </div>
            </button>

            <div class="collapse" id="ongoing" class="bgColorGrey">
                <?php
                if (sizeof($ongoing_auctions) == 0) { ?>
                    <p>You haven't made any bids on ongoing auctions </p>
                <?php } else { ?>
                    <div class="d-flex flex-wrap text-left justify-flex-start">
                        @each('partials.card', $ongoing_auctions, 'auction')
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="collapsible mt-2 mb-4">
            <button class="collapsible_btn w-100 py-2 text-left" data-toggle="collapse" data-target="#watchlist" aria-expanded="false" aria-controls="watchlist">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <h5 class="font-weight-bold">Watchlist</h5>
                    <i class=" fas fa-chevron-down mr-2 p-0"></i>
                </div>
            </button>

            <div class="collapse" id="watchlist" class="bgColorGrey">
                <?php
                if (sizeof($watchlist) == 0) { ?>
                    <p>You still haven't added any auctions to your watchlist </p>
                <?php } else { ?>
                    <div class="d-flex flex-wrap text-left justify-flex-start">
                        @each('partials.card', $watchlist, 'auction')
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="mx-auto d-flex">
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