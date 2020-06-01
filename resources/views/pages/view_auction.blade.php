@extends('layouts.app')

@section('title', $auction->species_name)

@section('content')

<meta property="og:title" content="BidMonkeys- Your animal auction website" />
<meta property="og:description" content="{{ $auction->species_name }}. Is this animal what you're looking for?" />
<meta property="og:image" content="{{asset('assets/logo.png')}}" />
<meta property="og:locale" content="en_GB" />

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

            <div class="d-flex flex-column bgColorGrey bid-bar">
                @if($auction->id_status == 0)
                <h2 class="text-center mb-3 mx-auto mt-5">{{ $auction->current_price }} €</h2>
                <h6 class="text-center font-weight-bold" id="countdown" data-id="{{ $countdown }}"></h6>
                @elseif($auction->id_status == 1)
                <div class="mb-3 px-3 mt-4 w-100">
                    <h2 class="text-center mb-4">Finished</h2>
                    <div class="d-flex flex-row w-100 justify-content-between">
                        <h6>Final Price: </h6>
                        <h6 class="font-weight-bold">{{ $auction->current_price }} €</h6>
                    </div>
                    <div class="d-flex flex-row w-100 justify-content-between">
                        <h6>Winner: </h6>
                        <h6 class="font-weight-bold">@if($winner != null) {{ $winner->name }} @else No One @endif</h6>
                    </div>
                    <div class="d-flex flex-row w-100 justify-content-between">
                        <h6>Ended: </h6>
                        <h6 class="font-weight-bold">{{ $auction->ending_date }}</h6>
                    </div>
                </div>
                @elseif($auction->id_status == 2)
                <div class="mb-3 px-3 mt-4 w-100">
                    <h2 class="text-center mb-4">Cancelled</h2>
                    <div class="d-flex flex-row w-100 justify-content-between">
                        <h6 class="text-left">Highest Bid: </h6>
                        <h6 class="font-weight-bold">{{ $auction->current_price }} €</h6>
                    </div>
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger my-4 mx-3">{{ session('error') }}</div>
                @elseif(session('success'))
                <div class="alert alert-success my-4 mx-3">{{ session('success') }}</div>
                @endif

                @if($role == 'seller')

                @if($auction->id_status == 0)
                <a class="btn btn-green mx-3 no-print" href="{{ route('edit_auction', ['id' => $auction->id]) }}">Edit Auction</a>
                @endif
                <form class="d-flex flex-row mt-3 mx-3 no-print" method="POST" action="{{ route('delete_auction', ['id' => $auction->id]) }}">
                    {{ csrf_field() }}
                    {{method_field('DELETE')}}
                    <button class="btn btn-green mx-auto w-100" type="submit">Delete Auction</button>
                </form>
                @endif

                @if($role == 'admin')

                @if($auction->id_status == 0)
                <a id="stop_button" data-id="{{ $auction->id }}" class="btn btn-green mx-3 no-print" href="#">Stop Auction</a>
                @endif
                <form class="d-flex flex-row mt-3 mx-3 no-print" method="POST" action="{{ route('delete_auction', ['id' => $auction->id]) }}">
                    {{ csrf_field() }}
                    {{method_field('DELETE')}}
                    <button class="btn btn-green mx-auto w-100" type="submit">Delete Auction</button>
                </form>
                @endif

                @if($role == 'user')

                @if($auction->id_status == 0)
                <form method="POST" action="{{ route('create_bid', ['id' => $auction->id, 'id_user' => Auth::id()]) }}">
                    <div class="d-flex flex-row mx-3 no-print">
                        {{ csrf_field() }}
                        <label style="display:none" for="bid_value">Bid Value</label>
                        <input type="number" id="bid_value" name="bid_value" placeholder="Bid Value" class="form-control mr-1 w-50" required>
                        <button class="btn btn-green mx-auto w-50" type="submit">Bid</button>
                    </div>
                </form>

                <form method="POST" action="{{ route('auto_bid', ['id' => $auction->id, 'id_user' => Auth::id()]) }}">
                    <div class="d-flex flex-row mt-3 mx-3 no-print">
                        {{ csrf_field() }}
                        <label style="display:none" for="bid_value"></label>
                        <input type="number" id="auto_bid_value" name="bid_value" placeholder="Bid Value" class="form-control mr-1 w-50" required>
                        <button class="btn btn-green mx-auto w-50" type="submit">Auto Bid</button>
                    </div>
                </form>
                @endif

                <a class="btn btn-green mt-3 mx-3 no-print" href="{{ route('add_report', ['id' => $auction]) }}">Report </a>

                @if($auction->id_status == 0)
                    @if($add_watchlist)
                        <a data-id="{{ $auction->id }}" class="btn btn-green mx-3 mt-3 addWatchlist" href="#" >Add to Watchlist</a>
                    @else
                        <a data-id="{{ $auction->id }}" class="btn btn-green mx-3 mt-3 remWatchlist" href="#" >Remove from Watchlist</a>
                    @endif
                @endif

                @endif
                @if($role == 'guest')
                @if($auction->id_status == 0)
                <div class="d-flex flex-row mx-3 no-print">
                    <label style="display:none" for="bid_value"></label>
                    <input type="number" id="bid_value" placeholder="Bid Value" class="form-control mr-1 w-50">
                    <a class="btn btn-green mx-auto w-50" href="/login">Bid</a>
                </div>
                <div class="d-flex flex-row mx-3 mt-3 no-print">
                    <label style="display:none" for="autobid_value"></label>
                    <input type="number" id="autobid_value" placeholder="Bid Value" class="form-control mr-1 w-50">
                    <a class="btn btn-green mx-auto w-50" href="/login">Auto Bid</a>
                </div>
                @endif
                <a class="btn btn-green mt-3 mx-3 no-print" href="/login">Report</a>
                @if($auction->id_status == 0)
                <a class="btn btn-green mt-3 mx-3 no-print" href="/login">Add to Watchlist</a>
                @endif
                @endif
                <h2 class="mb-3 mx-auto mt-5">Bidding History</h2>

                <div class="h-25 mx-3">
                    @each('partials.bid_entry', $last_bids, 'bid')

                    @if(sizeof($last_bids) == 0)
                    <p class="text-center">No bids yet</p>
                    @elseif(sizeof($bidding_history) > 4)
                    <div class="p-2 popup w-100" data-toggle="modal" data-target="#bidsModal">
                        <p class="colorGreen text-center text-decoration-underline mx-auto no-print"><u class="text-center">See More</u></p>
                    </div>
                    @endif

                    <div class="modal fade" id="bidsModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                            <div class="modal-content mx-auto">
                                <div class="modal-header">
                                    <h2 class="ml-2">Bidding History</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="overflow-auto h-100 mx-2">
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
                <p class="text-box">{{ $auction->description }}</p>
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
                        @foreach($skills as $skill)
                        <p>&#8226; {{ $skill->type }}</p>
                        @endforeach
                        @if(sizeof($skills) == 0)
                        <p>None</p>
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-row">
                    <p class="font-weight-bold">Ending Date:&nbsp;</p>
                    <p>{{ $auction->ending_date }}</p>
                </div>

                <h3 class="my-3">Seller</h3>
                <div class="d-flex flex-row mb-4 align-items-center">
                    <div class="d-flex flex-row align-items-center">
                        <img class="rounded-circle mr-2 cover" width="70" height="70" src="{{url($seller_photo)}}" alt="{{$seller->name}}">
                    </div>
                    <div class="d-flex flex-column align-items-start">
                        <h5 class="font-weight-bold">{{ $seller->name }}</h5>
                        @if($seller->rating == null)
                        <h6>No reviews yet</h6>
                        @elseif($seller->rating > 0)
                        <h6>{{$seller->rating}} stars</h6>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection