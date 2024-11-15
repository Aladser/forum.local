<?php

namespace App\Core;

abstract class Controller
{
    public View $view;
    protected string $site_name;

    public function __construct()
    {
        $this->site_name = env('SITE_NAME');
        $this->view = new View();
    }
}
