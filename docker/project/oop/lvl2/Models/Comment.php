<?php

namespace Models;

use Models\Users\User;
use Services\Db;

class Comment extends ActiveRecordEntity
{

    protected string $text;

    protected int $authorId;
    protected int $articleId;

    protected ?string $createdAt = null;

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function setArticleId(int $articleId): void
    {
        $this->articleId = $articleId;
    }

    public function getAuthorId(): int
    {
        return (int)$this->authorId;
    }

    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getTime(): string
    {
        return $this->createdAt;
    }

    public static function create(array $fields, User $user): Comment
    {
        $comment = new Comment();

        $comment->setText($fields['text']);
        $comment->setAuthorId($user->getId());
        $comment->setArticleId($fields['articleId']);

        $comment->save();
        return $comment;
    }

    public static function getAllByArticleId(int $articleId): array
    {
        $db = Db::getInstance();
        return $db->query('select * from ' . static::getTableName() . ' where article_id = ' . $articleId . ';', [], static::class);
    }

    protected static function getTableName(): string
    {
        return 'comments';
    }
}