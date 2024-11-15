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
     * @param string|null $add_head      дополнительный head
     * @param string|null $routes        cписок роутов
     */
    public function generate(string $page_name, string $template_view, string $content_view, ?array $data = null, ?array $content_js = null, ?string $content_css = null, ?string $add_head = null, ?array $routes = null): void
    {
        $authuser = UserService::getAuthUser();
        $CSRF = UserService::createCSRFToken();

        $site_address = env('SITE_ADDRESS');
        $routes['logout'] = route('logout');
        require_once dirname(__DIR__, 2).'/public/views/'.$template_view;
    }
}
