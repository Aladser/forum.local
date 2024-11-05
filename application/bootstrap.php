<?php

namespace App;

use App\Core\Route;

/**Корневая папка */
define('ROOT_FOLDER', dirname(__DIR__, 1));

require ROOT_FOLDER.'/vendor/autoload.php';
Route::start();
