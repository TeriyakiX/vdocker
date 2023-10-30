<?php

namespace Controllers;

use Exceptions\UnauthorizedException;
use Models\Comment;

class CommentsController extends AbstractController
{
    /**
     * @throws UnauthorizedException
     */
    public function add(): void
    {
        if($this->user === null) {
            throw new UnauthorizedException();
        }

        if(!empty($_POST)) {
            $comment = Comment::create($_POST, $this->user);
            header('Location: /articles/' . $comment->getArticleId(), true, 302);
            exit();
        }
    }
}