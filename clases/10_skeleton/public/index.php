<?php
// // // ? http://www.slimframework.com/docs/v4/start/web-servers.html

// // use Slim\Factory\AppFactory;

// // require __DIR__ . '/vendor/autoload.php';

// // $app = AppFactory::create();

// // // ...

// // // If you are adding the pre-packaged ErrorMiddleware set `displayErrorDetails` to `false`
// // $app->addErrorMiddleware(false, true, true);

// // // ...

// // $app->run();


// use Psr\Http\Message\ResponseInterface as Response;
// use Psr\Http\Message\ServerRequestInterface as Request;
// use Slim\Factory\AppFactory;

// require __DIR__ . '/../vendor/autoload.php';

// $app = AppFactory::create();
// $app->setBasePath("/utn/utn-prog-3/clases/6_slim");



// $app->get('/', function (Request $request, Response $response, $args) {
//     $response->getBody()->write("Hello world!");
//     return $response;
// });

// // $app->post()
// // $app->delete()
// // $app->put()
// // /comer[/]: los [] lo hacen opcional
// // /comer/{id}: {} variable
// $app->get('/comer/{id}', function (Request $request, Response $response, $args) {
//     $method = $request->getMethod();
//     $params = $request->getQueryParams();// para GET
//     // $params = $request->getParsedBody();// para POST & PUT
//     $params = (object) $params;
//     // $params =  json_encode($params);
//     $username = $args['username'] ?? '';

//     $arr = array(
//         "nombre"=>"Diego", 
//         "args"=>$args, // comer/{id}
//         "username"=>$args['username'] ?? '', // url ?username=ddalairac
//         "params"=>$params, 
//         "method"=>$method, 
//         "header"=>$request->getheaders()
//         // "header"=>$request->getheader("Host")
//     );
//     $response->getBody()->write(json_encode($arr));

//     return $response
//         ->withHeader('Content-Type','application/json')
//         ->withStatus(200);
// });





(require __DIR__ . './../config/bootstrap.php')->run();

// require_once __DIR__. "./../src/models/alumno.php";

// require __DIR__ . './../vendor/autoload.php';
// use App\Models\Alumno;

// $all = new Alumno();
// $all->saludar();