<?php

namespace Models\Comments;

use Models\Users\User;
use Models\ActiveRecordEntity;
use Models\Articles\Article;
use Services\Db;

class Comment extends ActiveRecordEntity
{
    protected $authorId;
    protected $articlesId;
    protected $text;
    protected $date;

    public function setText(string $text) {
        $this->text = $text;
    }

    public function getText(): string {
        return $this->text;
    }

    public function setAuthor(User $author): void {
        $this->authorId = $author->getId();
    }

    public function setArticle(Article $article): void {
        $this->articlesId = $article->getId();
    }

    public function getArticleId(): int {
        return $this->articlesId;
    }

    public function setAuthorId(User $author)
    {
        $this->authorId = $author->getId();
    }

    public function getAuthorId(): User
    {
        return User::getById($this->authorId);
    }

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $sql = 'SELECT * FROM `'.static::getTableName().'` WHERE `id`='.$id;
        $entyties = $db->query($sql, [], static::class);
        return $entyties ? $entyties[0] : null;
    }

    public static function getAllByArticleId(int $articleId): ?array {
        $db = Db::getInstance();
        $sql = 'SELECT * FROM `' . static::getTableName() . '` WHERE `articles_id` = :articleId';
        return $db->query($sql, [':articleId' => $articleId], static::class);
    }    

    protected static function getTableName(): string {
        return 'comments';
    }


    
}