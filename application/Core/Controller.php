<?php

namespace App\Core;

abstract class Controller
{
    public View $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public static function redirect(string $url): void
    {
        header("Location: $url");
    }

    public function render(string $template_view, string $content_view, ?string $page_name = null, ?array $data = null, ?array $content_js = null, ?string $content_css = null)
    {
        if (is_null($page_name)) {
            $page_name = env('SITE_NAME');
        }
        $this->view->generate($template_view, $content_view, $page_name, $data, $content_js, $content_css);
    }
}
