<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
  /**
   * Shows the hot deals in homepage.
   *
   * @return Response
   */
  public function show()
  {
    $auctions = DB::select('SELECT auctionsB.id, auctionsB.species_name, auctionsB.current_price, auctionsB.age, auctionsB.ending_date, url, auctionsB.id_status
    FROM (((
      SELECT auctions.*, count(*) AS num_bids
        FROM  (auctions JOIN bids ON auctions.id = bids.id_auction)
        WHERE id_status=0
        GROUP BY  auctions.id) AS auctionsB
    JOIN animal_photos ON auctionsB.id = animal_photos.id_auction) JOIN images ON animal_photos.id = images.id)   
    ORDER BY num_bids DESC 
    LIMIT 3
    ;');

    return view('pages.homepage',  ['auctions' => $auctions]);
  }


  //   $auctions = DB::table('auctions')->join('bids', 'auctions.id', '=', 'bids.id_auction')->join('animal_photos', 'auctions.id', '=', 'animal_photos.id_auction')->join('images', 'animal_photos.id', '=', 'images.id')->where('id_status','=', 0)->select('auctions.*', count(*))->$get();

}
