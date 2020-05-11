<?php
// // ? http://www.slimframework.com/docs/v4/start/web-servers.html

// use Slim\Factory\AppFactory;

// require __DIR__ . '/vendor/autoload.php';

// $app = AppFactory::create();

// // ...

// // If you are adding the pre-packaged ErrorMiddleware set `displayErrorDetails` to `false`
// $app->addErrorMiddleware(false, true, true);

// // ...

// $app->run();


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/utn/utn-prog-3/clases/6_slim");

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/comer', function (Request $request, Response $response, $args) {
    $response->getBody()->write("a comerlaaaaa!");
    return $response;
});

$app->run();