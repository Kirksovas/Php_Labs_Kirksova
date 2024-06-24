<?php require(__DIR__.'/../header.php'); ?> 
<!-- Подключение шапки сайта-->

<!--Форма для обновлении статьи-->
<form action="<?=dirname($_SERVER['SCRIPT_NAME']);?>/article/update/<?=$article->getId();?>" method="POST"> 
  <!--Поле ввода имени статьи-->
  <div class="form-group"> 
    <label for="name">Name article</label> 
    <!--Ввод имени статьи, предварительно заполненное текущим значением-->
    <input type="text" class="form-control" id="name" name="name" value="<?=$article->getName();?>"> 
  </div> 
  <!--Ввода текста статьи-->
  <div class="form-group"> 
    <label for="text">Text</label> 
    <!--Ввод текста статьи, предварительно заполненный текущим значением-->
    <textarea name="text" id="text" class="form-control"><?=$article->getText();?></textarea> 
  </div> 
  <!--Скрытое поле для передачи ID автора статьи-->
  <input type="hidden" name="authorId" value="<?=$article->getAuthorId();?>"> 
  <button type="submit" class="btn btn-primary">Update</button> 
</form> 

<?php require(__DIR__.'/../footer.php'); ?> 