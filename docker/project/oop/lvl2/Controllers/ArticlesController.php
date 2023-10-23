<?php

namespace Controllers;

use View\View;
use Models\Articles\Article;
use Models\Users\User;

class ArticlesController
{
    private View $view;

    public function View(int $articleId) : void
    {
        $article = Article::getById($articleId);
        if ($article == null)
        {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHtml('articles/view.php', ['article' => $article]);
    }

    public function add(): void
    {
        $author = User::getById(1);

        $article = new Article();
        $article->setAuthor($author);
        $article->setName('Новое название статьи');
        $article->setText('Новый текст статьи');

        $article->save();

        var_dump($article);
    }

    public function edit(int $articleId) : void
    {
        $article = Article::getById($articleId);

        if($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $article->setName('asd');
        $article->setText('dsa');

        $article->save();
    }

    public function delete (int $id) : void
    {
        $article = Article::getById($id);
        if ($article) {
            $article->delete();
            var_dump($article);
        } else {
            echo('статьи с таким id нет');
        }
    }

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../templates');
    }
}