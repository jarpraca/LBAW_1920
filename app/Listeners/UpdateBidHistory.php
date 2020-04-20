<?php

namespace App\Listeners;

use App\Events\BidCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateBidHistory
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Handle the event.
     *
     * @param  BidCreated  $event
     * @return void
     */
    public function handle(BidCreated $event)
    {
        // @{{ sendAjaxRequest("delete", "/api/images/" + id, null, imageDeletedHandler) }};
        // echo '<script type="text/javascript> alert("hello!");  </script>';
        echo '<script> console.log('.json_encode($event->bid).')</script>';
        echo $event->bid;
        return redirect()->route('view_auction', ['id' => $event->bid->id_auction]);
    }
}
