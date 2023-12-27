<?php

namespace App\Core;

class View
{
    /** создать верстку страницы.
     *
     * @param [type] $pageName имя страницы
     * @param [type] $template_view шаблон-страница
     * @param [type] $content_view контент-страница
     * @param [type] $data данные
     * @param [type] $content_js js-скрипты
     * @param [type] $content_css css-скрипты
     * @param [type] $header доп.заголовок
     */
    public function generate(
        $pageName,
        $template_view,
        $content_view,
        $data = null,
        $content_js = null,
        $content_css = null,
        $header = null
    ): void {
        require_once dirname(__DIR__, 1).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$template_view;
    }
}
