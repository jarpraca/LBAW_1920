@extends('layouts.app')

@section('title', 'View Auction')

@section('content')
<div class="bg-white pt-4">
    <section class="mainBody">

        <h1 class="mt-3 colorGreen">{{ $auction->species_name }}</h1>

        <div class="d-flex flex-row">
            <h3>{{ $auction->name }}&nbsp;&nbsp;&nbsp;&nbsp;{{ $auction->age }}</h3>

        </div>

        <div class="d-flex flex-wrap">
            <div class="imgAuction">
                <img class="w-100" src="{{url($picture_name)}}" alt="{{$picture_name}}">
            </div>

            <div class="text-center d-flex flex-column bgColorGrey bid-bar">
                <h2 class="mb-3 mx-auto mt-5">{{ $auction->current_price }}€</h2>
                @if($role == 'seller')
                <a class="btn btn-green mx-3" href="{{ route('edit_auction', ['id' => $auction->id]) }}">Edit Auction</a>
                <form class="btn-green mt-3 mx-3 borderRadiusForm" method="POST" action="{{ route('delete_auction', ['id' => $auction->id]) }}">
                    {{ csrf_field() }}
                    {{method_field('DELETE')}}
                    <button class="btn btn-green mx-3" type="submit">Delete Auction</button>
                </form>
                @endif
                @if($role == 'admin')
                <a id="stop_button" data-id="{{ $auction->id }}" class="btn btn-green mx-3" href="#" >Stop Auction</a>
                <form class="btn-green mt-3 mx-3 borderRadiusForm" method="POST" action="{{ route('delete_auction', ['id' => $auction->id]) }}">
                    {{ csrf_field() }}
                    {{method_field('DELETE')}}
                    <button class="btn btn-green mx-3" type="submit">Delete Auction</button>
                </form>               
                @endif
                @if($role == 'user')
                <form method="POST" action="{{ route('create_bid', ['id' => $auction->id, 'id_user' => Auth::id()]) }}">
                    <div class="d-flex flex-row mx-3">
                        {{ csrf_field() }}
                        <input type="number" name="bid_value" placeholder="Bid Value" class="form-control mr-1">
                        <button class="btn btn-green mx-auto w-75" type="submit">Bid</button>
                    </div>
                </form>

                <div class="d-flex flex-row mx-3 mt-3">
                    <input type="number" placeholder="Bid Value" class="form-control mr-1">
                    <a class="btn btn-green mx-auto w-75" href="#">Auto Bid</a>
                </div>
                <a class="btn btn-green mt-3  mx-3" href="#">Report</a>
                <a class="btn btn-green mt-3  mx-3" href="#">Add to Watchlist</a>
                @endif
                @if($role == 'guest')
                <div class="d-flex flex-row mx-3">
                    <input type="number" placeholder="Bid Value" class="form-control mr-1">
                    <a class="btn btn-green mx-auto w-75" href="/register">Bid</a>

                </div>
                <div class="d-flex flex-row mx-3 mt-3">
                    <input type="number" placeholder="Bid Value" class="form-control mr-1">
                    <a class="btn btn-green mx-auto w-75" href="/register">Auto Bid</a>
                </div>
                <a class="btn btn-green mt-3  mx-3" href="/register">Report</a>
                <a class="btn btn-green mt-3  mx-3" href="/register">Add to Watchlist</a>
                @endif
                <h2 class="mb-3 mx-auto mt-5">Bidding History</h2>

                <div class="h-25">
                    @each('partials.bid_entry', $last_bids, 'bid')

                    <?php
                    if (sizeof($last_bids) == 0) { ?>
                        <p>No bids yet</p>
                    <?php } else { ?>
                        <div class="p-2 popup" data-toggle="modal" data-target="#bidsModal">
                            <p class="colorGreen text-decoration-underline mx-auto"><u>See More</u></p>
                        </div>
                    <?php } ?>
                    <div class="modal fade" id="bidsModal" tabindex="-1" role="dialog" aria-labelledby="bidsModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content mx-auto">
                                <div class="modal-header">
                                    <h2 class="mt-3">Bidding History</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="overflow-auto h-100">
                                        @each('partials.bid_entry', $bidding_history, 'bid')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row mt-3">
            <div class="w-75">
                <h3>Description</h3>
                <p>{{ $auction->description }}</p>
                <div class="d-flex flex-row">
                    <p class="font-weight-bold">Category:&nbsp;</p>
                    <p>{{ $category }}</p>
                </div>
                <div class="d-flex flex-row">
                    <p class="font-weight-bold">Development Stage:&nbsp;</p>
                    <p>{{ $dev_stage }}</p>
                </div>
                <div class="d-flex flex-row">
                    <p class="font-weight-bold">Color:&nbsp;</p>
                    <p>{{ $color }}</p>
                </div>
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row">
                        <p class="font-weight-bold">Skills&nbsp;</p>
                    </div>
                    <div class="d-flex flex-column ml-3">
                        <?php
                        foreach ($skills as $skill) { ?>
                            <p>&#8226 {{ $skill->type }}</p>
                        <?php } ?>
                    </div>
                </div>
                <div class="d-flex flex-row">
                    <p class="font-weight-bold">Ending Date:&nbsp;</p>
                    <p>{{ $auction->ending_date }}</p>
                </div>

                <h3 class="my-3">Seller</h3>
                <div class="d-flex flex-row mb-4 align-items-center">
                    <div class="d-flex flex-row align-items-center">
                        <img class="rounded-circle mr-2 cover" width="70px" height="70px" src="{{url($seller_photo)}}">
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <h5 class="font-weight-bold">{{ $seller->name }}</h5>
                        <?php
                        if ($seller->rating == null) { ?>
                            <h6>No reviews yet</h6>
                        <?php } else { ?>
                            <h6>{{$seller->rating}} stars</h6>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection