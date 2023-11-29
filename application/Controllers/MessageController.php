<?php

namespace Aladser\Controllers;

use Aladser\Core\Controller;

/** диалоги */
class MessageController extends Controller
{
    public function index()
    {
        // имя пользователя
        $username = Controller::getUserMailFromClient();

        $this->view->generate('template_view.php', 'message_list_view.php', 'message_list.css', '', "$username: диалоги");
    }
}
