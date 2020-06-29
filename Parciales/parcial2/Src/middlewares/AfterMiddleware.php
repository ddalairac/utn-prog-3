<?php
namespace App\Middleware;
use Psr\Http\Message\ServerRequestInterface as Request;
// use Psr\Http\Message\ResponseInterface as Response;
// use Psr\Http\Message\ServerRequestInterface as Request;
// use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AfterMiddleware {
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response {
        $response = $handler->handle($request);

        $StatusCode = $response->getStatusCode();
        $existingContent = (string) $response->getBody();
        if ($StatusCode < 300) {
            $existingContent = json_decode($existingContent) ?? $existingContent;
            $resFormat = [
                "status" => "Success",
                "data" => $existingContent,
            ];
        } else {
            $resFormat = [
                "status" => "Error",
                "message" => json_decode($existingContent)->error,
                // "trace" => json_decode($existingContent)->trace,
            ];
        }
        $response = new Response();
        $response->getBody()->write(json_encode($resFormat));

        // $response->getBody()->write(' AFTER');
        return $response
            ->withHeader("Content-type", "application/json")
            ->withStatus($StatusCode);
    }
}