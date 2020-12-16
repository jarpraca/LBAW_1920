<?php

namespace App\Policies;

use App\User;
use App\Auction;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ImagePolicy
{
    use HandlesAuthorization;

    public function deleteAvatar(User $user)
    {
      $admin = DB::table('admins')->where('id', '=', Auth::user()->id)->first();
      // Only a user or an admin can delete the picture
      return ($user->id == Auth::user()->id || $admin != null);
    }

    public function deleteAnimalPhoto(Auction $auction)
    {
      $admin = DB::table('admins')->where('id', '=', Auth::user()->id)->first();
      // Only an auction owner or an admin can delete a photo associated to the auction
      return (Auth::user()->id == $auction->id_seller || $admin != null);
    }
}
