<?php require(__DIR__.'/../header.php'); ?>
 <!-- Сверху каждой страницы подключение через директорию  шапку, а снизу футор -->
<table class="table mt-4">
  <thead>
     <!-- таблица -->
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Text</th>
      <th scope="col">Author</th>
    </tr>
  </thead>
  <tbody>
    <!-- Перебор массива статей и отображение каждой статьи в строке таблицы -->
    <?php foreach($articles as $article): ?>
    <tr>
      <th scope="row">
        <!-- Ссылка на страницу конкретной статьи с использованием ID статьи -->
        <a href="<?= dirname($_SERVER['SCRIPT_NAME']) . '/article/' . $article->getId(); ?>">
          <?= htmlspecialchars($article->getName()); //вывода имени статьи на странице с автоматическим преобразованием специальных символов HTML в их эквиваленты сущностей?>
        </a>
      </th>
      <td><?= htmlspecialchars($article->getText()); ?></td>
      <td><?= htmlspecialchars($article->getAuthorId()); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php require(__DIR__.'/../footer.php'); ?>
