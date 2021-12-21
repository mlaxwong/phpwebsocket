<?php

namespace App\Socket;

use App\Contracts\Socket\ServerContract;
use React\Socket\SocketServer;

class Server extends SocketServer implements ServerContract
{
    public function __construct(string $address = '0.0.0.0', string $port = '8081')
    {
        parent::__construct("$address:$port");
    }
}
