<?php

namespace Controllers;

use Models\Users\User;
use Models\Users\UsersAuthService;
use View\View;

abstract class AbstractController
{
    protected View $view;

    protected ?User $user;

    public function __construct()
    {
        $this->user = UsersAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../templates');
        $this->view->setVar('user', $this->user);
    }
}