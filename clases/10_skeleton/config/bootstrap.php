<?php 

require __DIR__ . './../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Config\;

$app = AppFactory::create();
$app->setBasePath("/utn/utn-prog-3/clases/10_skeleton/public");

// Rutas
(require_once __DIR__."./routes.php")($app);




return $app;