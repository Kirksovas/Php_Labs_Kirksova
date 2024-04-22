<?php
// Начинаем сессию
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сообщения по хештегу</title>
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

        /* Стили для сообщений */
        .message {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <?php
        // Проверяем, авторизован ли пользователь
        if (isset($_SESSION['user_id'])) {
            // Если авторизован, выводим кнопки для добавления и удаления #
            echo '<a class="action-button blue-link" href="add_hashtag.php">Добавить #</a>';
            echo '<a class="action-button blue-link" href="delete_hashtag.php">Удалить #</a>';
            echo '<a class="action-button blue-link" href="logout.php" onclick="return confirmLogout();">Выйти</a>'; // Добавляем кнопку для выхода из аккаунта
        } else {
            // Если не авторизован, выводим кнопку для авторизации
            echo '<a class="login-button blue-link" href="login.php">Войти</a>';
        }
        ?>
    </div>

    

    <div class="center-content">
        <?php
        $hashtag_id = isset($_GET['hashtag']) ? $_GET['hashtag'] : '';

        // Если идентификатор хештега не пустой, выполняем запрос к базе данных
        if (!empty($hashtag_id)) {
            // Подключение к базе данных
            $db = new mysqli('localhost', 'root', '', 'sorter');
            if ($db->connect_error) {
                die("Ошибка подключения к базе данных: " . $db->connect_error);
            }

            // Защита от SQL-инъекций
            $hashtag_id_safe = $db->real_escape_string($hashtag_id);

            // Получаем название хештега по его ID
            $query_hashtag_name = "SELECT name FROM Hashtag WHERE id_hashtag = '$hashtag_id_safe'";
            $result_hashtag_name = $db->query($query_hashtag_name);
            $row_hashtag_name = $result_hashtag_name->fetch_assoc();
            $hashtag_name = $row_hashtag_name['name'];

            // Запрос на получение сообщений по хештегу из базы данных
            $query_messages = "SELECT SMS.*, Hashtag.name AS hashtag_name 
                               FROM SMS 
                               LEFT JOIN Hashtag ON SMS.id_hashtag = Hashtag.id_hashtag 
                               WHERE Hashtag.id_hashtag = '$hashtag_id_safe'";
            $result_messages = $db->query($query_messages);

            // Вывод сообщений
            if ($result_messages && $result_messages->num_rows > 0) {
                echo "<h1>Сообщения по хештегу: $hashtag_name</h1>"; // Используем имя хештега в заголовке
                while ($row_message = $result_messages->fetch_assoc()) {
                    echo "<div class='message'>";
                    echo "<p>{$row_message['description']}</p>";
                    // Проверяем, есть ли хештег, и если есть, выводим его
                    if (!empty($row_message['hashtag_name'])) {
                        echo "<p>Хештег: {$row_message['hashtag_name']}</p>";
                    } else {
                        echo "<p>Хештег: Нет хештега</p>";
                    }
                    echo "<p>Дата: {$row_message['data']}</p>";
                    echo "</div>";
                }
            } else {
                echo "Нет сообщений для выбранного хештега";
            }

            // Закрытие соединения с базой данных
            $db->close();
        } else {
            // Если идентификатор хештега пустой, выводим сообщение об ошибке
            echo "Идентификатор хештега не был передан в GET-запросе";
        }
        ?>
    </div>
</body>

</html>
