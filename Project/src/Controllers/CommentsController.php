<?php

namespace Controllers;

use Models\Comments\Comment; // Подключаем модель комментариев
use Models\Users\User; // Подключаем модель пользователей
use View\View; // Подключаем класс для работы с представлением
use Models\Articles\Article; // Подключаем модель статей

class CommentsController
{
    private $view;

    // Конструктор класса
    public function __construct() {
        $this->view = new View(__DIR__ . '/../../templates'); // Создаем объект для работы с представлением
    }

    // Метод для отображения комментариев
    public function view(int $commentId) {
        $article = Article::getById($commentId); // Получаем статью по ID комментария
        $comments = Comment::findAll(); // Получаем все комментарии

        // Если комментарии не найдены, отображаем страницу ошибки
        if ($comments === null) {
            $this->view->renderHtml('/errors/error.php', [], 404);
            return;
        }
        
        // Отображаем страницу с комментариями
        $this->view->renderHtml('/comments/comment.php', ['article' => $article, 'comments' => $comments]);
    }

    // Метод для редактирования комментария
    public function edit(int $commentId): void {
        $comment = Comment::getById($commentId); // Получаем комментарий по ID
        if ($comment === null) {
            // Если комментарий не найден, отображаем страницу ошибки
            $this->view->renderHtml('/errors/error.php', [], 404);
            return;
        }

        $article = Article::getById($comment->getArticleId()); // Получаем статью, к которой привязан комментарий
        $comment->setText($_POST['text']); // Устанавливаем новый текст комментария
        $comment->save(); // Сохраняем изменения

        header('Location:/articles/' . $article->getId()); // Перенаправляем на страницу со статьей
    }

    // Метод для добавления комментария
    public function add(): void {
        $author = User::getById((int)$_POST['author_id']); // Получаем автора комментария

        // Получаем ID статьи из URL
        $pattern = '~^comments/add/(\d+)$~';
        preg_match($pattern, $_GET['route'], $matches);
        $article = Article::getById($matches[1]); // Получаем статью по ID

        // Если автор или статья не найдены, отображаем страницу ошибки
        if ($author === null || $article === null) {
            $this->view->renderHtml('/errors/error.php', [], 404);
            return;
        }

        // Создаем новый комментарий и сохраняем его
        $comment = new Comment();
        $comment->setAuthor($author);
        $comment->setArticle($article);
        $comment->setText($_POST['text']);
        $comment->save();

        header('Location:/articles/' . $article->getId()); // Перенаправляем на страницу со статьей
    }

    // Метод для удаления комментария
    public function delete(int $commentId): void {
        $comment = Comment::getById($commentId); // Получаем комментарий по ID
        if ($comment === null) {
            // Если комментарий не найден, отображаем страницу ошибки
            $this->view->renderHtml('/errors/error.php', [], 404);
            return;
        }
        $article = Article::getById($comment->getArticleId()); // Получаем статью, к которой привязан комментарий
        $comment->delete(); // Удаляем комментарий
    
        header('Location:/articles/' . $article->getId()); // Перенаправляем на страницу со статьей
        exit(); // Завершаем выполнение скрипта
    }
}
