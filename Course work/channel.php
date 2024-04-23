<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Канал</title>
    <style>
        .header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: right;
        }

        .channel-container {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .channel-name {
            font-size: 24px;
            font-weight: bold;
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

        .channel-description {
            margin-bottom: 10px;
        }

        .channel-date {
            color: #666;
            margin-bottom: 20px;
        }

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
        if (isset($_SESSION['user_id'])) {
            echo '<a class="action-button blue-link" href="add_hashtag.php">Добавить #</a>';
            echo '<a class="action-button blue-link" href="delete_hashtag.php">Удалить #</a>';
            echo '<a class="action-button blue-link" href="add_sms.php?id=' . $_GET['id'] . '">Добавить сообщение</a>';
            echo '<a class="action-button blue-link" href="logout.php" onclick="return confirmLogout();">Выйти</a>';
        } else {
            echo '<a class="login-button" href="login.php">Войти</a>';
        }
        ?>
    </div>

    <?php
$db = new mysqli('localhost', 'root', '', 'sorter');
if ($db->connect_error) {
    die("Ошибка подключения к базе данных: " . $db->connect_error);
}

$channel_id = $_GET['id'];

$query = "SELECT * FROM Channel WHERE id_channel = $channel_id";
$result = $db->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo '<div class="channel-container">';
    echo '<div class="channel-name">' . $row["name"] . '</div>';
    echo '<div class="channel-description">' . $row["description"] . '</div>';
    echo '<div class="channel-date">Дата создания: ' . $row["data"] . '</div>';
    echo '</div>';

    $query_messages = "SELECT SMS.*, Hashtag.name AS hashtag_name 
               FROM SMS 
               LEFT JOIN Hashtag ON SMS.id_hashtag = Hashtag.id_hashtag
               WHERE SMS.id_channel = $channel_id AND SMS.save = 1";
    $result_messages = $db->query($query_messages);

    if ($result_messages->num_rows > 0) {
        while ($row_message = $result_messages->fetch_assoc()) {
            echo "<div class='message'>";
            echo "<p>{$row_message['description']}</p>";
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
$db->close();
?>

</body>
</html>
