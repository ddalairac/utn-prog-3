<?php 

require __DIR__ . './../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Config\Database;

new Database();

$app = AppFactory::create();
$app->setBasePath("/utn/utn-prog-3/clases/10_skeleton/public");

// errorHandler
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;
$app->addRoutingMiddleware();


// Define Custom Error Handler
$customErrorHandler = function (
    ServerRequestInterface $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails,
    ?LoggerInterface $logger = null
) use ($app) {
    // $logger->error($exception->getMessage());

    $payload = ['error' => $exception->getMessage()];

    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write(
        json_encode($payload, JSON_UNESCAPED_UNICODE)
    );

    return $response;
};

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true/* , $logger */);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);


// Rutas
(require_once __DIR__."./routes.php")($app);

// Middlewares
(require_once __DIR__."./../Src/middlewares/Middlewares.php")($app);


return $app;