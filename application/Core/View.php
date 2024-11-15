<?php

namespace App\Core;

use App\Services\UserService;

class View
{
    /**
     * создать верстку страницы.
     *
     * @param string      $page_name     имя страницы
     * @param string      $template_view путь шаблон-страницы
     * @param string      $content_view  путь контент-страницы
     * @param array|null  $data          массив данных страницы
     * @param array|null  $content_js    массив js-скриптов
     * @param string|null $content_css   путь css-файла
     */
    public function generate(string $template_view, string $content_view, string $page_name, ?array $data, ?array $content_js, ?string $content_css): void
    {
        $authuser = UserService::getAuthUser();
        $CSRF = UserService::createCSRFToken();
        require_once dirname(__DIR__, 2).'/public/views/'.$template_view;
    }
}
