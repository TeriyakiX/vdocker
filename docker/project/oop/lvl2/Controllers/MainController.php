<?php

namespace Controllers;
use View\View;
use Models\Articles\Article;

class MainController
{
    private View $view;
    public function main() : void
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }

    public function sayHello(string $name) : void
    {
        $this->view->renderHtml('main/hello.php', ['name' => $name, 'title' => 'Страница приветствия']);
    }

    public function sayBye(string $name) : void
    {
        echo('Пока, ' . $name);
    }

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../templates');
    }
}