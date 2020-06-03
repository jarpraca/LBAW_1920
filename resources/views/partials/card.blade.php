<a class="auct-card-ref" href="/auctions/{{$auction->id}}" data-id="{{ $auction->id }}">
    <div class="card auct-card mt-4" data-id="{{ $auction->id }}">
        <img class="card-img-top" src="{{url($auction->url)}}" alt="{{$auction->url}}">
        <div class="card-body d-flex flex-column">
            <h5 class="card-title font-weight-bold text-dark">{{$auction->species_name}}</h5>
            <div class="d-flex flex-row justify-content-between">
                <p class="card-text">{{$auction->current_price}} €</p>
                <p class="card-text">{{$auction->age}}</p>
            </div>
            <div class="d-flex flex-row justify-content-between align-items-center">
                <p><span class="card-text smallFont mr-1">@if($auction->id_status == 0) Ending: @else Ended: @endif</span> {{ $auction->ending_date }} </p>
                @inject('admin', 'App\Admin')
                @if($auction->id_status == 0 && Auth::check() && !$admin::find(Auth::id()))
                <i class="{{ $auction->watchlisted ? 'fas colorGreen' : 'far colorGrey' }} fa-eye fa-2x {{ $auction->watchlisted ? 'remWatchlistEye' : 'addWatchlistEye' }}" data-id="{{ $auction->id }}"></i>
                @endif
            </div>
        </div>
    </div>
</a>