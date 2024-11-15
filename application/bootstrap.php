<?php

namespace App;

use App\Core\Route;
use Illuminate\Database\Capsule\Manager as Capsule;

use function App\Core\env;

/**Корневая папка */
define('ROOT_FOLDER', dirname(__DIR__, 1));

require ROOT_FOLDER.'/vendor/autoload.php';

// подключение к БД
$capsule = new Capsule();
$capsule->addConnection([
    'driver' => env('DB_DRIVER'),
    'host' => env('DB_HOST'),
    'database' => env('DB_NAME'),
    'username' => env('DB_USER'),
    'password' => env('DB_PASSWORD'),
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

Route::start();
