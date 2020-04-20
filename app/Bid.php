<?php

namespace App;

use App\Events\BidCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Bid extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    use Notifiable;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => BidCreated::class,
    ];
}
