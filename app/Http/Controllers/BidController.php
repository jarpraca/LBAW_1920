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
   * @param  int  $card_id
   * @param  Request request containing the description
   * @return Response
   */
  public function create(Request $request, $id_auction, $id_user)
  {
    $bid = new Bid();
    $bid->id_auction = $id_auction;
    $bid->id_buyer = $id_user;
    $bid->value = $request->input('bid_value');
    
    // $this->authorize('create', $bid);

    $bid->save();
    event(new BidCreated($bid));

    return redirect()->route('view_auction', ['id' => $id_auction]);
    // return $bid;
  }

    /**
     * Deletes an individual item.
     *
     * @param  int  $id
     * @return Response
     */
    // public function delete(Request $request, $id)
    // {
    //   $item = Item::find($id);

    //   $this->authorize('delete', $item);
    //   $item->delete();

    //   return $item;
    // }

}
