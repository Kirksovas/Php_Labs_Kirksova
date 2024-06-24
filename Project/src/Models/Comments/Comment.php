<?php

namespace Models\Comments;

use Models\Users\User; // Подключение класса User
use Models\ActiveRecordEntity; // Подключение родительского класса ActiveRecordEntity
use Models\Articles\Article; // Подключение класса Article
use Services\Db; // Подключение сервиса для работы с базой данных

class Comment extends ActiveRecordEntity {
    protected $authorId; // ID автора комментария
    protected $articlesId; // ID статьи, к которой относится комментарий
    protected $text; // Текст комментария
    protected $date; // Дата создания комментария

    // Метод для установки текста комментария
    public function setText(string $text) {
        $this->text = $text;
    }

    // Метод для получения текста комментария
    public function getText(): string {
        return $this->text;
    }

    // Метод для установки автора комментария
    public function setAuthor(User $author): void {
        $this->authorId = $author->getId();
    }

    // Метод для установки статьи, к которой относится комментарий
    public function setArticle(Article $article): void {
        $this->articlesId = $article->getId();
    }

    // Метод для получения ID статьи, к которой относится комментарий
    public function getArticleId(): int {
        return $this->articlesId;
    }

    // Метод для установки ID автора комментария
    public function setAuthorId(User $author) {
        $this->authorId = $author->getId();
    }

    // Метод для получения объекта автора комментария
    public function getAuthorId(): User {
        return User::getById($this->authorId);
    }

    // Метод для получения объекта комментария по ID
    public static function getById(int $id): ?self {
        $db = Db::getInstance();
        $sql = 'SELECT * FROM `' . static::getTableName() . '` WHERE `id`=' . $id;
        $entities = $db->query($sql, [], static::class);
        return $entities ? $entities[0] : null;
    }

    // Метод для получения всех комментариев по ID статьи
    public static function getAllByArticleId(int $articleId): ?array {
        $db = Db::getInstance();
        $sql = 'SELECT * FROM `' . static::getTableName() . '` WHERE `articles_id` = :articleId';
        return $db->query($sql, [':articleId' => $articleId], static::class);
    }

    // Метод для получения имени таблицы комментариев в базе данных
    protected static function getTableName(): string {
        return 'comments';
    }
}
