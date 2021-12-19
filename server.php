<?php

use App\Chat;
use DI\ContainerBuilder;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require __DIR__ . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/config/di.php');
$container = $containerBuilder->build();

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat
        )
    ),
    8081
);

$server->run();