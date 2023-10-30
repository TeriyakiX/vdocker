<?php

namespace Controllers;
use Models\Articles\Article;

class MainController extends AbstractController
{
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

}