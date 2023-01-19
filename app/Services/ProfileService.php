<?php

namespace App\Services;

use App\Http\Resources\UserResource;

class ProfileService
{
    public function profile(User $user)
    {
        return new UserResource($user);
    }

}
