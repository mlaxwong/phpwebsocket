<?php

$app = new App\Foudation\Application();

$app->register(App\Socket\SocketProvider::class);

return $app;
