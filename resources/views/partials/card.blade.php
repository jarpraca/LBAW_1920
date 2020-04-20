<div class="card auct-card mt-4" data-id="{{ $auction->id }}">
  <img class="card-img-top"  src="{{url($auction->url)}}" alt="{{$auction->url}}">
  <div class="card-body d-flex flex-column">
    <h5 class="card-title font-weight-bold text-dark"> {{$auction->species_name}}</h5>
    <div class="d-flex flex-row justify-content-between mr-2">
      <p class="card-text">{{$auction->current_price}}€</p>
      <p class="card-text">{{$auction->age}}</p>
    </div>

    <p class="card-text smallFont">Ending time </p>
    <p> {{ $auction->ending_date }} </p>
    <div class="d-flex flex-row justify-content-between align-items-center">
      <i class="far fa-eye fa-2x colorGrey"></i>
      <a href="/auctions/{{$auction->id}}" class="btn btn-green align-self-end">View Auction</a>
    </div>
  </div>
</div>