<?php
    $db = require('db.php');
    $connect = mysqli_connect($db['host'], $db['username'], $db['password'], $db['database']);
    if (mysqli_connect_errno()) print_r(mysqli_connect_error());
    if(!isset($_GET['p'])) $_GET['p'] = 'view';
    if (isset($_POST['firstname'])){
        $sql = "INSERT INTO `peoples`
                (`firstname`, `name`, `lastname`, `gender`, `date`, `phone`, `email`, `adress`, `comment`)
                VALUES (
                '".htmlspecialchars($_POST['firstname'])."',
                '".htmlspecialchars($_POST['name'])."',
                '".htmlspecialchars($_POST['lastname'])."',                       
                '".$_POST['gender']."',
                '".$_POST['date']."',
                '".$_POST['phone']."',
                '".htmlspecialchars($_POST['email'])."',                       
                '".htmlspecialchars($_POST['adress'])."',                       
                '".htmlspecialchars($_POST['comment'])."'
                )";        
                mysqli_query($connect, $sql);
            if (mysqli_errno($connect)) print_r(mysqli_error($connect));
            }
    require('header.php');
        if (isset($_GET['p']) &&
        ($_GET['p']=='view'|| $_GET['p']=='add' ||
        $_GET['p']=='update' || $_GET['p']=='delete')) include(''.$_GET['p'].'.php.');
    require('footer.php');
?>