<?php
namespace App\Middleware;

use App\Utils\Autenticate;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Utils\RespErrorException;

class BeforeMiddleware {
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
        $existingContent = (string) $response->getBody();

        $response = new Response();

        try {
            $user = Autenticate::validateReq($request);
            $response->getBody()->write($existingContent);
        } catch (\Throwable $th) {
                throw new RespErrorException("No tiene permisos para realizar esta operacion.", 401);
        }

        return $response;
    }
}