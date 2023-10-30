<?php

namespace Controllers;

use Exceptions\InvalidArgumentException;
use Exceptions\ForbiddenException;
use Exceptions\NotFoundException;
use View\View;
use Exceptions\UnauthorizedException;
use Models\Comment;
use Models\Articles\Article;
use Models\Users\User;

class ArticlesController extends AbstractController
{

    public function view(int $articleId): void
    {
        $article = Article::getById($articleId);
        $comments = Comment::getAllByArticleId($articleId);
        if ($article == null) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php', ['article' => $article]);
        $this->view->renderHtml('articles/view.php', ['article' => $article, 'comments' => $comments]);
    }

    public function add(): void
    {
        $author = User::getById(1);
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        if ($this->user->getRole() !== "admin") {
            throw new ForbiddenException();
        }

        $article = new Article();
        $article->setAuthor($author);
        $article->setName('Новое название статьи');
        $article->setText('Новый текст статьи');
        if (!empty($_POST)) {
            try {
                $article = Article::create($_POST, $this->user);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
                return;
            }

            $article->save();
            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        var_dump($article);
        $this->view->renderHtml('articles/add.php');
    }

    public function edit(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        if ($this->user->getRole() !== 'admin') {
            throw new ForbiddenException();
        }

        $article->setName('asd');
        $article->setText('dsa');
        if (!empty($_POST)) {
            try {
                $article->updateFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/edit.php', ['error' => $e->getMessage(), 'article' => $article]);
                return;
            }

            $article->save();
            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }

    public function delete(int $id): void
    {
        $article = Article::getById($id);
            throw new NotFoundException();
        }


}