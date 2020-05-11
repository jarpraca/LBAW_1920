<div class="d-flex flex-row ml-4 mb-0 bid_entry" data-id="{{ $bid->id }}">
  <p class="w-50 ml-3 text-left mb-0 ">@if($bid->name != null) {{$bid->name}} @else Deleted User @endif</p>
  <p class="w-50 text-center mb-0">{{$bid->value}}€</p>
</div>