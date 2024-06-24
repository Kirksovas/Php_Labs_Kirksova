<?php

namespace Controllers;

use Models\Comments\Comment;
use Models\Users\User;
use View\View;
use Models\Articles\Article;

class CommentsController
{
    private $view;

    public function __construct() {
        $this->view = new View(__DIR__ . '/../../templates');
    }

    public function view(int $commentId) {
        $article = Article::getById($commentId);
        $comments = Comment::findAll();
        if ($comments === null) {
            $this->view->renderHtml('/errors/error.php', [], 404);
            return;
        }
        
        $this->view->renderHtml('/comments/comment.php', ['article' => $article, 'comments' => $comments]);
    }

    public function edit(int $commentId): void {
        $comment = Comment::getById($commentId);
        if ($comment === null) {
            $this->view->renderHtml('/errors/error.php', [], 404);
            return;
        }

        $article = Article::getById($comment->getArticleId());
        $comment->setText($_POST['text']);
        $comment->save();

        header('Location:student-231/Project/www/articles'.$article->getId());
    }
    public function add(): void {
        $author = User::getById((int)$_POST['author_id']);;

        $pattern = '~^comments/add/(\d+)$~';
        preg_match($pattern, $_GET['route'], $matches);

        $article = Article::getById($matches[1]);

        if ($author === null || $article === null) {
            $this->view->renderHtml('/errors/error.php', [], 404);
            return;
        }

        $comment = new Comment();
        $comment->setAuthor($author);
        $comment->setArticle($article);
        $comment->setText($_POST['text']);
        $comment->save();

        header('Location:Project/www/articles'.$article->getId());
    }
    public function delete(int $commentId): void {
        $comment = Comment::getById($commentId);
        if ($comment === null) {
            $this->view->renderHtml('/errors/error.php', [], 404);
            return;
        }
        $article = Article::getById($comment->getArticleId());
        $comment->delete();
    
        header('Location:Project/www/articles/' . $article->getId());
        exit();
    }
}