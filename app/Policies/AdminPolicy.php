<?php

namespace App\Policies;

use App\Admin;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AdminPolicy
{
    use HandlesAuthorization;

    public function show(User $user)
    {
        // Only an admin can view the admin page
        // return TRUE;
        return Admin::find(Auth::id()) == null;
    }

    public function update(User $user)
    {
        // Only an admin can update a report
        return Admin::find($user->id) != null;
    }
}
