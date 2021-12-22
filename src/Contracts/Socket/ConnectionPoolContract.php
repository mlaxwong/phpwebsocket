<?php

namespace App\Contracts\Socket;

use React\Socket\ConnectionInterface;

interface ConnectionPoolContract
{
    public function add(ConnectionInterface $connection): void;
}
