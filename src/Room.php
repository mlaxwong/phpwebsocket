<?php

namespace App;

class Room
{
    private array $users = [];

    public function __construct(
        public string $name
    ) {}

    public function getUsers(): array
    {
        return $this->users;
    }
}