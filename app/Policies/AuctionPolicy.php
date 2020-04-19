<?php

namespace App\Policies;

use App\User;
use App\Auction;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AuctionPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
      // Any user can create a new auction
      return Auth::check();
    }

    public function delete(User $user, Auction $auction)
    {
      // Only an auction owner can delete it
      return $user->id == $auction->id_seller;
    }

    public function update(User $user, Auction $auction)
    {
      // Only an auction owner can update it
      return $user->id == $auction->id_seller;
    }
}
