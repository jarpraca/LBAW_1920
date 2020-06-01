<?php

namespace App\Http\Controllers;

use App\Watchlist;
use Illuminate\Support\Facades\Auth;
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
        $auctions = DB::select('
        SELECT auctionsB.id, auctionsB.species_name, auctionsB.current_price, auctionsB.age, auctionsB.ending_date, url, auctionsB.id_status
            FROM (((
            SELECT auctions.*, count(*) AS num_bids
                FROM  (auctions JOIN bids ON auctions.id = bids.id_auction)
                WHERE id_status=0
                GROUP BY  auctions.id) AS auctionsB
            JOIN animal_photos ON auctionsB.id = animal_photos.id_auction) JOIN images ON animal_photos.id = images.id)   
            ORDER BY num_bids DESC 
            LIMIT 3
            ;');

        if (Auth::check()) {
            foreach ($auctions as $auction) {
                $watchlist = Watchlist::where('id_auction', $auction->id)->where('id_buyer', Auth::id())->first();
                if ($watchlist != null)
                    $auction->watchlisted = true;
                else
                    $auction->watchlisted = false;
            }
        } else
            foreach ($auctions as $auction) {
                $auction->watchlisted = false;
            }

        return view('pages.homepage',  ['auctions' => $auctions]);
    }

}
