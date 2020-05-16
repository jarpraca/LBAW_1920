<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Events\BidCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Auction;

class BidController extends Controller
{
  /**
   * Creates a new item.
   *
   * @param  int  $id_auction
   * @param  int  $id_user
   * @param  Request request containing the description
   * @return Response
   */
  public function create(Request $request, $id_auction, $id_user)
  {
    $auction = Auction::find($id_auction);
    
    if($auction->current_price >= $request->input('bid_value')){
      return back()->withError("A bid must be higher than the previous bid")->withInput();
    }

    $bid = new Bid();
    // $this->authorize('create', $bid);

    $bid->id_auction = $id_auction;
    $bid->id_buyer = $id_user;
    $bid->value = $request->input('bid_value');
    $bid->save();

    event(new BidCreated($bid));

    $highest = DB::select('select maximum, id_buyer from bids where id_auction=' . $bid->id_auction . ' and maximum is not null order by maximum desc limit 1');

    if((count($highest) > 0)  && ($highest[0]->maximum > $bid->value) && ($id_user != $highest[0]->id_buyer)){

      $bid2 = new Bid();
      // $this->authorize('create', $bid);

      $bid2->id_auction = $bid->id_auction;
      $bid2->id_buyer = $highest[0]->id_buyer;
      $bid2->value = $bid->value + 1;
      $bid2->save();

      event(new BidCreated($bid2));
    }

    return redirect()->route('view_auction', ['id' => $id_auction]);
    // return $bid;
  }

  public function auto(Request $request, $id_auction, $id_user)
  {

    $auction = Auction::find($id_auction);

    if($auction->current_price >= $request->input('bid_value')){
      return back()->withError("A bid must be higher than the previous bid")->withInput();
    }

    $bid = new Bid();
    // $this->authorize('create', $bid);

    $bid->id_auction = $id_auction;
    $highest = DB::select('select maximum, id_buyer from bids where id_auction=' . $bid->id_auction . ' and maximum is not null order by maximum desc limit 1');
    $bid->id_buyer = $id_user;
    $bid->value = $request->input('current_price') + 1;
    $bid->maximum = $request->input('bid_value');
    $bid->save();

    event(new BidCreated($bid));

    if((count($highest) > 0)  && ($highest[0]->maximum > $bid->value) && ($id_user != $highest[0]->id_buyer)){
      
      if($bid->maximum > $highest[0]->maximum){

        $bid2 = new Bid();
        // $this->authorize('create', $bid);

        $bid2->id_auction = $bid->id_auction;
        $bid2->id_buyer = $bid->id_buyer;
        $bid2->value = $highest[0]->maximum + 1;
        $bid2->save();

        event(new BidCreated($bid2));

      }

      else{

        $bid2 = new Bid();
        // $this->authorize('create', $bid);

        $bid2->id_auction = $bid->id_auction;
        $bid2->id_buyer = $highest[0]->id_buyer;
        $bid2->value = $bid->maximum + 1;
        $bid2->save();

        event(new BidCreated($bid2));

      }

    }

    return redirect()->route('view_auction', ['id' => $id_auction]);
    // return $bid;
  }

}
