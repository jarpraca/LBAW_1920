<?php

namespace App\Policies;

use App\Admin;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AdminPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        // Any user can create report a seller
        return Auth::check();
    }

    public function update(User $user)
    {
        // Only an admin can update a report
        return Admin::find($user->id) != null;
    }
}
