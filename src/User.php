<?php

namespace App;

use App\Contracts\Auth\IdentityContract;

class User implements IdentityContract
{
    public function __construct(
        protected string $name
    ) {}

    public function getName(): string
    {
        return $this->name;
    }
}
