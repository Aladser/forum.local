<?php

namespace App\Core;

use function App\config;

class View
{
    /**
     * создать верстку страницы.
     *
     * @param string      $pageName      имя страницы
     * @param string      $template_view путь шаблон-страницы
     * @param string      $content_view  путь контент-страницы
     * @param array|null  $data          массив данных страницы
     * @param array|null  $content_js    массив js-скриптов
     * @param string|null $content_css   путь css-файла
     * @param string|null $add_head      дополнительный head
     * * @param string|null $routeArray      cписок роутов
     */
    public function generate(
        string $pageName,
        string $template_view,
        string $content_view,
        array $data = null,
        array $content_js = null,
        string $content_css = null,
        string $add_head = null,
        array $routeArray = null,
    ): void {
        // базовый адрес сайта
        $site_address = config('SITE_ADDRESS');
        
        require_once dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$template_view;
    }
}
