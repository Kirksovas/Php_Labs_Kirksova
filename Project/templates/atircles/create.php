<?php require(__DIR__.'/../header.php');?>
<form action="<?=dirname($_SERVER['SCRIPT_NAME']);?>/article/store" method="POST">
<!-- Форма для создания новой статьи -->
  <div class="form-group">
    <label for="name">Name article</label>
    <!-- Поле для ввода названия новой статьи -->
    <input type="text" class="form-control" id="name" name="name">
  </div>
  <div class="form-group">
    <label for="text">Text</label>
    <!-- Поле для ввода текста новой статьи -->
    <textarea name="text" id="text" class="form-control"></textarea>
  </div>
   <!-- Скрытое поле для передачи айди автора статьи (по умолчанию - 1) -->
  <input type="hidden" name="authorId" value="1">
  <!-- Кнопка для отправки формы и сохранения новой статьи -->
  <button type="submit" class="btn btn-primary">Save</button>
</form>
<?php require(__DIR__.'/../footer.php');?>