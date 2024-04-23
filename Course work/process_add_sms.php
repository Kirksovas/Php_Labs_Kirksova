<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['description']) && isset($_POST['hashtag']) && isset($_POST['visibility']) && isset($_POST['channel_id'])) {
            $description = $_POST['description'];
            $hashtag_id = $_POST['hashtag'];
            $visibility = $_POST['visibility'];
            $channel_id = $_POST['channel_id'];

            $db = new mysqli('localhost', 'root', '', 'sorter');
            if ($db->connect_error) {
                die("Ошибка подключения к базе данных: " . $db->connect_error);
            }

            $stmt = $db->prepare("INSERT INTO SMS (id_hashtag, id_users, id_channel, description, data, save) VALUES (?, ?, ?, ?, NOW(), ?)");
            $stmt->bind_param("iiiii", $hashtag_id, $_SESSION['user_id'], $channel_id, $description, $visibility);
            if ($stmt->execute()) {
                $stmt->close();
                $db->close();
                
                header("Location: channel.php?id=" . $channel_id);
                exit();
            } else {
                echo "Ошибка при добавлении сообщения: " . $stmt->error;
            }
        } else {
            echo "Не удалось получить все необходимые данные для добавления сообщения";
        }
    } else {
        echo "Данные должны быть отправлены методом POST";
    }
} else {
    header("Location: login.php");
    exit();
}
?>
