<?php 

require __DIR__ . './../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Config\Database;
use App\Utils\Autenticate;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."./../");
$dotenv->load();

new Database();
Autenticate::$key = $_SERVER['ENCRYPKEY'];

$app = AppFactory::create();
$app->setBasePath("/utn/utn-prog-3/Parciales/parcial2/public");

// Error Handler
require_once __DIR__."./errorHandler.php";

// Rutas
(require_once __DIR__."./routes.php")($app);

// Middlewares
(require_once __DIR__."./Middlewares.php")($app);


return $app;