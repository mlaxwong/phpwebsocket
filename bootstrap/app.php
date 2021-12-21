<?php

$app = new App\Foudation\Application();

$app->set(App\Contracts\Socket\ServerContract::class, DI\create(React\Socket\SocketServer::class)->constructor('0.0.0.0:8081'));

$socket = $app->get(App\Contracts\Socket\ServerContract::class);

$socket->on('connection', function(React\Socket\ConnectionInterface $connection) {
    echo $connection->getRemoteAddress() . PHP_EOL;

    $connection->write("Hello " . $connection->getRemoteAddress() . "\n");
    $connection->on('data', function($data) use ($connection) {
        $connection->write($data);
    });
});

return $app;
