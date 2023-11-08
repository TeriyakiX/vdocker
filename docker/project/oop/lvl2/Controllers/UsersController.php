<?php


namespace Controllers;

use Exception;
use Exceptions\InvalidArgumentException;
use Models\Users\User;
use Models\Users\UsersAuthService;

class UsersController extends AbstractController
{
    public function signUp(): void
    {
        if (!empty($_POST)) {
            $user = null;
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
            } catch (Exception $e) {
            }

            if ($user instanceof User) {
                $this->view->renderHtml('users/signUpSuccessful.php');
            }
        } else {
            $this->view->renderHtml('users/signUp.php');
        }
    }

    public function login(): void
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('users/login.php');
    }

    public function logout(): void
    {
        setcookie('token', '0', 0, '/', '', false, true);
        header('Location: /');
    }
}