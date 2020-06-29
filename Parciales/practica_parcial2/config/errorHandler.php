<?php

// use Psr\Http\Message\ServerRequestInterface;
// use Psr\Log\LoggerInterface;
// use Slim\Psr7\Response;

// $app->addRoutingMiddleware();

// // Define Custom Error Handler
// $customErrorHandler = function (
//     ServerRequestInterface $request,
//     Throwable $exception,
//     bool $displayErrorDetails,
//     bool $logErrors,
//     bool $logErrorDetails,
//     ?LoggerInterface $logger = null
// ) use ($app) {
//     // $logger->error($exception->getMessage());

//     $response = $app->getResponseFactory()->createResponse();

//     $payload = ['error' => "Ocurrrio un error interno."];
//     $StatusCode = 500;
    
//     if (isset($exception)) {
//         $exCode = $exception->getCode();
//         if ($exCode < 599 && $exCode > 200) {
//             $payload = [
//                 'error' => $exception->getMessage(),
//                 'trace' => $exception->getTrace()
//             ];
//             $StatusCode = $exCode;
//         } 
//     } 

//     $response->getBody()->write(
//         json_encode($payload, JSON_UNESCAPED_UNICODE)
//     );

//     return $response->withStatus($StatusCode);
// };

// // Add Error Middleware
// $errorMiddleware = $app->addErrorMiddleware(true, true, true/* , $logger */);
// $errorMiddleware->setDefaultErrorHandler($customErrorHandler);