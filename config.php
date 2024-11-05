<?php

namespace App;

// --- конфиг сайта ---
function config($key)
{
    $env = parse_ini_file(__DIR__.'/.env');

    if (array_key_exists($key, $env)) {
        return $env[$key];
    } else {
        throw new \Exception("Параметр $key не существует");
    }
}
