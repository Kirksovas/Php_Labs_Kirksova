<?php include __DIR__ . '/../header.php'; ?>
<h1>
    <?= $article->getName() ?>
</h1>
<p>
    <?= $article->getText() ?>
</p>
<?php
// рег. выражение для проверки маршрута и извлечения айдишки комм.
$pattern = '~^comments/(\d+)$~';
// Проверка соответствия маршрута шаблону, и извлекаем айди комм. при + значении
preg_match($pattern, $_GET['route'], $matches);
?>
<h4>Комментарии:</h4>
<?php if (!empty($comments)): // проверка массива на пустоту?>
    <?php foreach ($comments as $comment): // переборка комментариев?>
        <?php if ($comment->getArticleId() == $matches[1]): // Проверка соответствия айди статьи комментария тому айдишнику что получили ?>
            <p style="display: inline-block;margin-top: 20px;">
            <!-- Форма для редактирования комментария -->
            <form action="<?= dirname($_SERVER['SCRIPT_NAME']); ?>/comments/edit/<?= $comment->getId(); ?>" method="post">
                <label><input style="padding: 10px;border-radius: 10px;" type="text" name="text"
                        value="<?= $comment->getText() ?>"></label>
                <br><br>
                <!-- Ссылка для удаления комментария -->
                <a class="btn btn-success" style="background-color: #CD1818; outline: none;"
                    href="<?= dirname($_SERVER['SCRIPT_NAME']); ?>/comments/delete/<?= $comment->getId(); ?>">Удалить</a>
                    <!-- Кнопка для сохранения изменений комментария -->
                <input class="btn btn-success" type="submit" value="Сохранить">
            </form>
            </p>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: // Значени если массив комментариев пуст?>
    <p>Комментариев пока нет.</p>
<?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>