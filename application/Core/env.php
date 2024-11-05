<?php

namespace App\Core;

// --- конфиг сайта ---
function env($key)
{
    $env_file = dirname(__DIR__, 2);
    $env = parse_ini_file("$env_file/.env");

    if (array_key_exists($key, $env)) {
        return $env[$key];
    } else {
        throw new \Exception("Параметр $key не существует");
    }
}
