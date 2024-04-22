<?php
// Начинаем сессию
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каналы</title>
    <style>
        /* Стили для шапки */

        .header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: right;
        }

        /* Стили для контейнера */
        .container {
            display: grid;
            grid-template-columns: 1fr 3cm 1fr;
        }

        /* Стили для каналов */
        .channels {
            display: flex;
            flex-direction: column;
            padding: 10px;
        }

        /* Стили для областей знаний */
        .fields {
            display: flex;
            flex-direction: column;
            padding: 10px;

        }

        .fields .flink {
            margin-bottom: 10px;

            /* Добавляем расстояние между ссылками */
        }

        /* Стили для ссылки */
        .channel-link,
        .blue-link {
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-right: 10px;
            cursor: pointer;
            color: white;
            background-color: #008CBA;
            border: none;
            margin-bottom: 10px;
        }

        h2 {
            margin-top: 0;
            /* Устанавливаем верхний отступ заголовка h2 */
            margin-bottom: 10px;
            /* Устанавливаем нижний отступ заголовка h2 */
        }

        /* Стили для ссылок */
        .flink {
            text-decoration: none;
            font-size: 24px;
            width: fit-content;
            margin-right: 10px;
            cursor: pointer;
            color: #483D8B;
            border: #008CBA solid 2px;
            word-wrap: break-word;
            /* Добавляем свойство для переноса слов */
        }


        /* Зеленая кнопка для канала с like=1 */
        .like-1 {
            background-color: green;
        }

        /* Красная кнопка для канала с like=0 */
        .like-0 {
            background-color: red;
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

    <h1>Каналы / Области знаний</h1>

    <div class="container">
        <!-- Каналы -->
        <div class="channels">
            <h2>Каналы</h2>
            <?php
            // Подключение к базе данных
            $db = new mysqli('localhost', 'root', '', 'sorter');
            if ($db->connect_error) {
                die("Ошибка подключения к базе данных: " . $db->connect_error);
            }

            // Получение списка каналов
            $query = "SELECT * FROM Channel";
            $result = $db->query($query);
            if ($result->num_rows > 0) {
                // Вывод ссылок для каждого канала
                while ($row = $result->fetch_assoc()) {
                    // Определяем класс ссылки в зависимости от значения like
                    $link_class = ($row["like"] == 1) ? "like-1" : "like-0";
                    // Формируем ссылку с ID канала в GET параметре
                    echo '<a class="channel-link ' . $link_class . '" href="channel.php?id=' . $row["id_channel"] . '">' . $row["name"] . '</a>';
                }
            } else {
                echo "Нет доступных каналов";
            }

            // Закрытие соединения с базой данных
            $db->close();
            ?>
        </div>

        <!-- Области знаний -->
        <div class="fields">
            <h2>Области знаний</h2>
            <?php
            // Подключение к базе данных
            $db = new mysqli('localhost', 'root', '', 'sorter');
            if ($db->connect_error) {
                die("Ошибка подключения к базе данных: " . $db->connect_error);
            }

            // Получение списка областей знаний
            $query = "SELECT * FROM Field";
            $result = $db->query($query);
            if ($result->num_rows > 0) {
                // Вывод областей знаний
                while ($row = $result->fetch_assoc()) {
                    // Формируем ссылку с ID области знаний в GET параметре
                    echo '<a class="flink" href="field.php?field=' . $row["name"] . '">' . $row["name"] . '</a>';
                }
            } else {
                echo "Нет доступных областей знаний";
            }

            // Закрытие соединения с базой данных
            $db->close();
            ?>
        </div>
    </div>
</body>

</html>
