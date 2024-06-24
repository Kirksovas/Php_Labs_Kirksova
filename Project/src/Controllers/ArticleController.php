<?php

namespace Controllers;

// Используемые классы
use View\View;
use Models\Articles\Article;
use Models\Users\User;
use Models\Comments\Comment;

class ArticleController
{
    public $view;
    // Конструктор, инициализирующий свойство view
    public function __construct()
    {
        // Создание экземпляра View и указание пути к шаблонам
        $this->view = new View(__DIR__ . '/../../templates/');
    }
    // Метод для отображения списка всех статей
    public function index()
    {
        $articles = Article::findAll(); //получаем
        $this->view->renderHtml('articles/index.php', ['articles' => $articles]); //отображаем
    }
    // Метод для отображения одной статьи по ID
    public function show(int $id)
    {
        $article = Article::getById($id); // получаем id
        if ($article === [] or $article === null) { //проверяем наличие
            $this->view->renderHtml('errors/error.php', [], 404);
            return;
        }
        $user = User::getFieldById('nickname', $article->getAuthorId());
        $comments = Comment::getAllByArticleId($id);
        $this->view->renderHtml('/articles/show.php', ['article' => $article, 'user' => $user, 'comments' => $comments]);  // Отображение страницы статьи с данными статьи, автора и комментариев
    }
    // Метод для отображения страницы создания статьи
    public function create()
    {
        return $this->view->renderHtml('articles/create.php');
    }
    // Метод для сохранения новой статьи
    public function store()
    {
        $article = new Article;
        // Устанавливаем свойства статьи из POST-запроса
        $article->setName($_POST['name']);
        $article->setText($_POST['text']);
        $article->setAuthorId($_POST['authorId']);
        $article->save(); // Сохранение статьи в базе данных
        header('Location:student-231/Project/www/articles'); // Перенаправление на страницу со списком статей
    }
    // Метод для отображения страницы редактирования статьи
    public function edit($id)
    {
        // Получение статьи по ID
        $article = Article::getById($id);
        return $this->view->renderHtml('articles/edit.php', ['article' => $article]); // Отображение страницы
    }
    // Метод для обновления статьи
    public function update($id)
    {
        $article = Article::getById($id);
        $article->setName($_POST['name']);
        $article->setText($_POST['text']);
        $article->setAuthorId($_POST['authorId']);
        $article->save();
        header('Location:' . dirname($_SERVER['SCRIPT_NAME']) . '/article/' . $article->getId());
    }
    // Метод для удаления статьи
    // Метод для удаления статьи
    public function delete($id)
    {
        $article = Article::getById($id);
        if ($article === null) {
            $this->view->renderHtml('/errors/error.php', [], 404);
            return;
        }

        // Получение всех комментариев, связанных со статьей, получения всех комментариев по айдишнику
        $comments = Comment::getAllByArticleId($id);

        // Удаление каждого комментария
        foreach ($comments as $comment) {
            $comment->delete();
        }

        // Удаление самой статьи
        $article->delete();

        // Перенаправление на страницу со списком статей
        header('Location: /articles');
        exit();
    }
}
