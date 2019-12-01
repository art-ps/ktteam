<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__ .  '/../', '.env.testing');
$dotenv->load();

$capsule = new Capsule;
$capsule->addConnection([
   "driver" => getenv('DB_CONNECTION'),
   "host" => getenv('DB_HOST'),
   "port" => getenv('DB_PORT'),
   "database" => getenv('DB_DATABASE'),
   "username" => getenv('DB_USERNAME'),
   "password" => getenv('DB_PASSWORD'),
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/../app/config.php');
$container = $containerBuilder->build();

return $container;
