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
    public function generate(string $template_view, string $content_view, ?string $page_name = null, ?array $data = null, ?array $content_js = null, ?string $content_css = null): void
    {
        $authuser = UserService::getAuthUser();
        $CSRF = UserService::createCSRFToken();
        if (is_null($page_name)) {
            $page_name = env('SITE_NAME');
        }

        require_once dirname(__DIR__, 2).'/public/views/'.$template_view;
    }
}
