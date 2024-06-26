<?php
$db = require 'db.php';
$connect = mysqli_connect($db['host'], $db['username'], $db['password'], $db['database']);
if (mysqli_connect_errno()) print_r(mysqli_connect_error());

if (isset($_GET['p']) && $_GET['p'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $deleted_lastname = '';

    $sql_select = "SELECT `firstname`, `lastname` FROM `peoples` WHERE `id` = $id";
    $res = mysqli_query($connect, $sql_select);
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        if ($row) {
            $deleted_firstname = $row['firstname'];
        }
    } else {
        echo 'Ошибка при выполнении запроса: ' . mysqli_error($connect);
    }

    $delete_query = "DELETE FROM `peoples` WHERE `id` = $id";
    $result = mysqli_query($connect, $delete_query);
    if ($result) {
        echo 'Запись с именем ' . $deleted_firstname . ' удалена' . '<br>';
        $sql = "ALTER TABLE peoples AUTO_INCREMENT = 1";
        $res = mysqli_query($connect, $sql);
    } else {
        echo 'Ошибка при удалении записи: ' . mysqli_error($connect);
    }
}

$sql_select_all = "SELECT `id`, `firstname`, LEFT(`name`, 1) AS name, LEFT(`lastname`, 1) AS lastname FROM `peoples`";
$res = mysqli_query($connect, $sql_select_all);

while ($arr = mysqli_fetch_assoc($res)) {
    echo '<a href="?p=delete&id=' . $arr['id'] . '">' . $arr['firstname'] . ' ' . $arr['name'] . '.' . $arr['lastname'] . '.</a><br>';
};
?>