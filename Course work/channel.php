<?php
// Начинаем сессию
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Канал</title>
    <style>
        /* Стили для шапки */
        .header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: right;
        }

        /* Стили для контейнера канала */
        .channel-container {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Стили для названия канала */
        .channel-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Стили для описания канала */
        .channel-description {
            margin-bottom: 10px;
        }

        /* Стили для даты канала */
        .channel-date {
            color: #666;
            margin-bottom: 20px;
        }

        /* Стили для сообщений канала */
        .message {
            margin-bottom: 10px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
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

    <?php
    // Подключение к базе данных
    $db = new mysqli('localhost', 'root', '', 'sorter');
    if ($db->connect_error) {
        die("Ошибка подключения к базе данных: " . $db->connect_error);
    }

    // Получение идентификатора канала из GET-параметра
    $channel_id = $_GET['id'];

    // Получение информации о канале из базы данных
    $query = "SELECT * FROM Channel WHERE id_channel = $channel_id";
    $result = $db->query($query);

    if ($result && $result->num_rows > 0) {
        // Вывод информации о канале
        $row = $result->fetch_assoc();
        echo '<div class="channel-container">';
        echo '<div class="channel-name">' . $row["name"] . '</div>';
        echo '<div class="channel-description">' . $row["description"] . '</div>';
        echo '<div class="channel-date">Дата создания: ' . $row["data"] . '</div>';
        echo '</div>';

        // Получение сообщений канала из базы данных
        $query_messages = "SELECT SMS.*, Hashtag.name AS hashtag_name 
                   FROM SMS 
                   LEFT JOIN Hashtag ON SMS.id_hashtag = Hashtag.id_hashtag
                   WHERE id_channel = $channel_id";
        $result_messages = $db->query($query_messages);

        // Вывод сообщений канала
        if ($result_messages->num_rows > 0) {
            // Вывод сообщений
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
            echo "Нет сообщений в этом канале";
        }
    } else {
        echo "Канал не найден";
    }
    // Закрытие соединения с базой данных
    $db->close();
    ?>
</body>
</html>
