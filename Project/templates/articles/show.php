<?php 
require (__DIR__ . '/../header.php'); 
?>

<!-- Шаблон карточки поста (артикула) -->
<div class="card mt-3" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title"><?= $article->getName(); //вывод названия?></h5> 
        <h6 class="card-subtitle mb-2 text-muted"><?= $user->getNickname(); //вывод никнейма ?></h6>>
        <p class="card-text"><?= $article->getText(); //вывод содержимого статьи ?></p>
        <a href="<?= dirname($_SERVER['SCRIPT_NAME']); ?>/article/edit/<?= $article->getId(); ?>" class="card-link">Edit Article</a> <!-- Ссылка на редактирование статьи -->
        <a href="<?= dirname($_SERVER['SCRIPT_NAME']); ?>/article/delete/<?= $article->getId(); ?>" class="card-link">Delete Article</a> <!-- Ссылка на удаление статьи -->
    </div>
</div>

<?php
$pattern = '~^article/(\d+)$~'; // Шаблон для регулярного выражения
preg_match($pattern, $_GET['route'], $matches); // Поиск совпадений по шаблону в строке URL
?>

<h4 class="card-title">Комментарии:</h4>

<?php if (!empty($comments)): // Проверка, не пуст ли массив комментариев ?>
    <?php foreach ($comments as $comment): // Перебор комментариев ?>
        <?php if ($comment->getArticleId() == $matches[1]): // Проверка, соответствует ли ID статьи комментария извлеченному ID ?>
            <div class="card" style="padding: 20px; margin-bottom: 10px; background-color: #E3F4F4">
                <p><b>Автор: </b><?= $comment->getAuthorId()->getNickname(); ?></p> <!-- Выводим никнейм автора комментария -->
                <p class="card-subtitle"><?= $comment->getText() ?></p> <!-- Выводим текст комментария -->
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: // Если массив комментариев пуст ?>
    <p>Комментариев пока нет.</p>
<?php endif; ?>

<div class="form">
    <form action="<?= dirname($_SERVER['SCRIPT_NAME']); ?>/comments/add/<?= $article->getId() ?>" method="post"> <!-- Форма для добавления комментария -->
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Текст комментария</label>
            <textarea type="text" name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea> <!-- Поле ввода текста комментария -->
            <label style="margin-top:30px;" for="idInput" class="form-label">ID автора</label>
            <input style="margin-top:30px;" type="text" name="author_id" id="idInput" value="<?= $user->getId(); ?>"> <!-- Поле ввода ID автора комментария -->
            <input style="width:0;height:0;border:none;background-color:none;" type="text" name="articles_id" value="<?= $article->getId(); ?>"> <!-- Скрытое поле для передачи ID статьи -->
        </div>
        <button class="btn btn-success" type="submit">Добавить</button> <!-- Кнопка для отправки формы и добавления комментария -->
    </form>
</div>

<p>
    <a class="btn btn-success" href="<?= dirname($_SERVER['SCRIPT_NAME']); ?>/comments/<?= $article->getId() ?>">Редактировать комментарии</a> <!-- Ссылка на редактирование комментариев -->
</p>

<?php 
require (__DIR__ . '/../footer.php'); // Подключаем подвал страницы
?>
