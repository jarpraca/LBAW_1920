<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Events\BidCreated;
use Illuminate\Http\Request;

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
    $bid = new Bid();
    // $this->authorize('create', $bid);

    $bid->id_auction = $id_auction;
    $bid->id_buyer = $id_user;
    $bid->value = $request->input('bid_value');
    $bid->save();

    event(new BidCreated($bid));

    return redirect()->route('view_auction', ['id' => $id_auction]);
    // return $bid;
  }

  public function auto(Request $request, $id_auction, $id_user)
  {
    $bid = new Bid();
    // $this->authorize('create', $bid);

    $bid->id_auction = $id_auction;
    $bid->id_buyer = $id_user;
    $bid->value = $request->input('bid_value');
    $bid->save();

    event(new BidCreated($bid));

    return redirect()->route('view_auction', ['id' => $id_auction]);
    // return $bid;
  }
}
