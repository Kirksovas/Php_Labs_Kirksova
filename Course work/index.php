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
        .header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: right;
        }
        .container {
            display: grid;
            grid-template-columns: 1fr 3cm 1fr;
        }
        .channels {
            display: flex;
            flex-direction: column;
            padding: 10px;
        }
        .fields {
            display: flex;
            flex-direction: column;
            padding: 10px;

        }

        .fields .flink {
            margin-bottom: 10px;
        }

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
            margin-bottom: 10px;
        }

        .flink {
            text-decoration: none;
            font-size: 24px;
            width: fit-content;
            margin-right: 10px;
            cursor: pointer;
            color: #483D8B;
            border: #008CBA solid 2px;
            word-wrap: break-word;
        }

        .like-1 {
            background-color: green;
        }

        .like-0 {
            background-color: red;
        }
    </style>
</head>

<body>
    <div class="header">
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a class="action-button blue-link" href="add_hashtag.php">Добавить #</a>';
            echo '<a class="action-button blue-link" href="delete_hashtag.php">Удалить #</a>';
            echo '<a class="action-button blue-link" href="logout.php" onclick="return confirmLogout();">Выйти</a>'; // Добавляем кнопку для выхода из аккаунта
        } else {
            echo '<a class="login-button blue-link" href="login.php">Войти</a>';
        }
        ?>
    </div>

    <h1>Каналы / Области знаний</h1>

    <div class="container">
        <div class="channels">
            <h2>Каналы</h2>
            <?php
            $db = new mysqli('localhost', 'root', '', 'sorter');
            if ($db->connect_error) {
                die("Ошибка подключения к базе данных: " . $db->connect_error);
            }
            $query = "SELECT * FROM Channel";
            $result = $db->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $link_class = ($row["like"] == 1) ? "like-1" : "like-0";
                    echo '<a class="channel-link ' . $link_class . '" href="channel.php?id=' . $row["id_channel"] . '">' . $row["name"] . '</a>';
                }
            } else {
                echo "Нет доступных каналов";
            }

            $db->close();
            ?>
        </div>
        <div class="fields">
            <h2>Области знаний</h2>
            <?php
            $db = new mysqli('localhost', 'root', '', 'sorter');
            if ($db->connect_error) {
                die("Ошибка подключения к базе данных: " . $db->connect_error);
            }
            $query = "SELECT * FROM Field";
            $result = $db->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<a class="flink" href="field.php?field=' . $row["name"] . '">' . $row["name"] . '</a>';
                }
            } else {
                echo "Нет доступных областей знаний";
            }
            $db->close();
            ?>
        </div>
    </div>
</body>

</html>
