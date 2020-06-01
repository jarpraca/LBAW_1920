<?php

namespace App\Policies;

use App\Bid;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;


class BidPolicy
{
    use HandlesAuthorization;

    public function create(Bid $bid)
    {
      return (Auth::check());
    }

}
