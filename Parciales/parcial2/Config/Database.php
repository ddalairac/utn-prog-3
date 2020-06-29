<?php

namespace Config;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;

class Database {
    function __construct() {

        $capsule = new Capsule;

        $capsule->addConnection([
            'driver' => $_SERVER['DRIVER'],
            'host' => $_SERVER['HOST'],
            'database' => $_SERVER['DB'],
            'username' => $_SERVER['USER'],
            'password' => $_SERVER['PASSWORD'],
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        // Set the event dispatcher used by Eloquent models... (optional)

        $capsule->setEventDispatcher(new Dispatcher(new Container));

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();
    }
}
