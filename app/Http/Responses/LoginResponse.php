<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Models\User;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
        // Get current user and check if user has role
        $user = User::find(auth()->user()->id);

        // Check if user has role
        $home = $user->hasRole('admin') ? config('fortify.admin') : config('fortify.home');

        // Redirect to home
        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect($home);

    }

}
