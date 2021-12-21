<?php

namespace App\Socket;

use React\Socket\ConnectionInterface;
use SplObjectStorage;

class ConnectionPool
{
    public function __construct(
        private SplObjectStorage $connections = new SplObjectStorage,
    ) {}

    public function add(ConnectionInterface $connection)
    {

    }
}
