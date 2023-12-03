<?php

namespace Aladser\Core;

abstract class Controller
{
    public View $view;
    protected ?DBCtl $dbCtl;

    public function __construct(DBCtl $dbCtl = null)
    {
        $this->view = new View();
        $this->dbCtl = $dbCtl;
    }

    /** создать CSRF-токен.
     * @throws \Exception
     */
    public static function createCSRFToken(): string
    {
        $csrfToken = hash('gost-crypto', random_int(0, 999999));
        $_SESSION['CSRF'] = $csrfToken;

        return $csrfToken;
    }
}
