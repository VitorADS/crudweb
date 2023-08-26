<?php

use App\Http\Router;

require __DIR__ . '/includes/app.php';

$router = new Router(URL);

include __DIR__ . '/routes/routes.php';

$router->run()->sendResponse();