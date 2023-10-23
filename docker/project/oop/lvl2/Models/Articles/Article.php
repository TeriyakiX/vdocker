<?php

namespace Models\Articles;

use Models\ActiveRecordEntity;
use Models\Users\User;

class Article extends ActiveRecordEntity
{
    protected string $articleName;

    protected string $text;

    protected int $authorId;

    protected ?string $createdAt = null;

    public function getAuthorId() : int
    {
        return (int) $this->authorId;
    }

    public function getAuthor() : User
    {
        return User::getById($this->authorId);
    }

    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text) : void
    {
        $this->text = $text;
    }

    public function getName(): string
    {
        return $this->articleName;
    }

    public function setName(string $name) : void
    {
        $this->articleName = $name;
    }

    protected static function getTableName() : string
    {
        return 'articles';
    }
}