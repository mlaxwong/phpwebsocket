<?php

namespace App\Socket;

use App\Contracts\Socket\ConnectionPoolContract;
use React\Socket\ConnectionInterface;
use SplObjectStorage;

class ConnectionPool implements ConnectionPoolContract
{
    public function __construct(
        private SplObjectStorage $connections = new SplObjectStorage,
    ) {}

    public function add(ConnectionInterface $connection): void
    {
        $this->connections->attach($connection);
    }
}
