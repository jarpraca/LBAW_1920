<?php

namespace App\Policies;

use App\User;
use App\Auction;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserPolicy
{
    use HandlesAuthorization;

    public function delete(User $user)
    {
      $admin = DB::table('admins')->where('id', '=', $user->id)->first();
      // Only an user or an admin can delete the account
      return ($user->id == Auth::user()->id || $admin != null);
    }

    public function update(User $user)
    {
      // Only an user can update the account
      return $user->id == Auth::user()->id;
    }
}
