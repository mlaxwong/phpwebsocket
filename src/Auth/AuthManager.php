<?php

namespace App\Auth;

use App\Contracts\Auth\IdentityContract;

class AuthManager
{
    protected IdentityContract|null $user;

    public function login(IdentityContract $user)
    {
        $this->user = $user;
    }

    public function logout()
    {

    }
}
