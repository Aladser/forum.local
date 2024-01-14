<?php

namespace App;

// --- конфиг сайта ---
function config($param)
{
    // --- список глобальных параметров ---
    $paramList = [
        // подключение к БД
        'HOST_DB' => 'localhost',
        'NAME_DB' => 'forum',
        'USER_DB' => 'admin',
        'PASS_DB' => '@admin@',
        // базовый адрес страницы
        'SITE_ADDRESS' => 'forum.local',
    ];

    try {
        if (array_key_exists($param, $paramList)) {
            return $paramList[$param];
        } else {
            throw new \Exception("Параметр $param не существует");
        }
    } catch (\Exception $ex) {
        exit($ex);
    }
}
