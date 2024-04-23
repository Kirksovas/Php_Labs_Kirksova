<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить сообщение</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .form-container {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 50%;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

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
            echo '<a class="action-button blue-link" href="logout.php" onclick="return confirmLogout();">Выйти</a>';
        } else {
            echo '<a class="login-button" href="login.php">Войти</a>';
        }
        ?>
    </div>

    <div class="form-container">
        <h2>Добавить сообщение</h2>
        <form action="process_add_sms.php" method="POST">
            <label for="description">Описание сообщения:</label>
            <textarea id="description" name="description" rows="4" cols="50"></textarea>
            <label for="hashtag">Выберите хэштег:</label>
            <select id="hashtag" name="hashtag">
                <?php
                $db = new mysqli('localhost', 'root', '', 'sorter');
                if ($db->connect_error) {
                    die("Ошибка подключения к базе данных: " . $db->connect_error);
                }

                $query_hashtags = "SELECT * FROM Hashtag";
                $result_hashtags = $db->query($query_hashtags);
                if ($result_hashtags->num_rows > 0) {
                    while ($row_hashtag = $result_hashtags->fetch_assoc()) {
                        echo '<option value="' . $row_hashtag['id_hashtag'] . '">' . $row_hashtag['name'] . '</option>';
                    }
                } else {
                    echo '<option value="">Нет доступных хэштегов</option>';
                }
                ?>
            </select>
            <label for="visibility">Выберите видимость:</label>
            <select id="visibility" name="visibility">
                <option value="1">Видно</option>
                <option value="0">Не видно</option>
            </select>
            <input type="hidden" name="channel_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <input type="submit" value="Добавить">
        </form>
    </div>
</body>
</html>
