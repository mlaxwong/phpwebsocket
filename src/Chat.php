<?php

namespace App;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use SplObjectStorage;

class Chat implements MessageComponentInterface
{
    protected $mem;
    protected $clients;

    public function __construct()
    {
        $this->clients = new SplObjectStorage;
        $this->mem = memory_get_usage();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $conn->send("{$conn->resourceId} connected");
        $this->print("New connection! ({$conn->resourceId})\n");
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "onMessage\n";
        $from->send('cipek' . $msg);
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    private function print(string $message)
    {
        $memoryUsage = memory_get_usage() - $this->mem;
        $totalClient = count($this->clients);
        echo "$message >> TOTAL CLIENT : $totalClient >> MEMORY USAGE : $memoryUsage\n";
    }
}
