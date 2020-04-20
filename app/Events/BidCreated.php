<?php

namespace App\Events;

use App\Bid;
use Illuminate\Queue\SerializesModels;

class BidCreated
{
    use SerializesModels;

    public $bid;

    /**
     * Create a new event instance.
     *
     * @param  \App\Bid  $bid
     * @return void
     */
    public function __construct(Bid $bid)
    {
        $this->bid = $bid;
    }
}