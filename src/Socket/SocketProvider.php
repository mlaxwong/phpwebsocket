<?php

namespace App\Socket;

use App\Contracts\Socket\ConnectionPoolContract;
use App\Foudation\ServiceProvider;
use React\Socket\ConnectionInterface;
use React\Socket\ServerInterface;
use React\Socket\SocketServer;

use function DI\create;

class SocketProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->set(ServerInterface::class,  create(SocketServer::class)->constructor('0.0.0.0:8081'));
        $this->app->set(ConnectionPoolContract::class, create(ConnectionPool::class));
    }

    public function boot(ServerInterface $socket, ConnectionPoolContract $pool): void
    {
        $socket->on('connection', function(ConnectionInterface $connection) use ($pool) {
            $pool->add($connection);
            echo $connection->getRemoteAddress() . PHP_EOL;

            $connection->write("Hello " . $connection->getRemoteAddress() . "\n");
            $connection->on('data', function($data) use ($connection) {
                $connection->write($data);
            });
        });
    }
}
