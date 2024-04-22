<?php
// Начинаем сессию
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Выбранная область</title>
    <style>
        /* Стили для шапки */
        .header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: right;
        }

        /* Стили для центрированного контента */
        .center-content {
            text-align: center;
            margin-top: 50px;
        }

        /* Добавляем стили для списка хештегов */
        .hashtag-list {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap; /* Разрешаем перенос элементов на новую строку */
            justify-content: center; /* Выравниваем хештеги по центру */
        }

        .hashtag-list li {
            margin: 5px; /* Добавляем расстояние между хештегами */
        }

        .hashtag-list li a {
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f0f0f0;
            transition: background-color 0.3s ease;
        }

        .hashtag-list li a:hover {
            background-color: #e0e0e0;
        }

    </style>
</head>

<body>
    <div class="header">
        <?php
        // Проверяем, авторизован ли пользователь
        if (isset($_SESSION['user_id'])) {
            // Если авторизован, можно добавить код для отображения дополнительных элементов управления, например, кнопки для добавления новых каналов
        } else {
            // Если не авторизован, выводим кнопку для авторизации
            echo '<a class="login-button" href="login.php">Войти</a>';
        }
        ?>
    </div>

    <div class="center-content">
        <?php
        // Получаем название выбранной области из GET-параметра
        $field_name = $_GET['field'] ?? '';

        // Выводим название выбранной области
        echo '<div class="field-name">' . $field_name . '</div>';

        // Подключение к базе данных
        $db = new mysqli('localhost', 'root', '', 'sorter');
        if ($db->connect_error) {
            die("Ошибка подключения к базе данных: " . $db->connect_error);
        }

        // Получаем хештеги, относящиеся к выбранной области
        $query_hashtags = "SELECT Hashtag.id_hashtag, Hashtag.name FROM Hashtag 
        INNER JOIN Field_Hashtag ON Hashtag.id_hashtag = Field_Hashtag.id_hashtag
        WHERE Field_Hashtag.id_field_hashtag = (SELECT id_field FROM Field WHERE name = '$field_name')";


        $result_hashtags = $db->query($query_hashtags);

        if ($result_hashtags && $result_hashtags->num_rows > 0) {
            // Выводим список хештегов
            echo '<ul class="hashtag-list">';
            while ($row_hashtag = $result_hashtags->fetch_assoc()) {
                echo '<li><a href="hashtags.php?hashtag=' . $row_hashtag['id_hashtag'] . '">' . $row_hashtag['name'] . '</a></li>';
            }
            echo '</ul>';
        } else {
            echo "Нет хештегов для выбранной области";
        }

        // Закрытие соединения с базой данных
        $db->close();
        ?>
    </div>
</body>

</html>
