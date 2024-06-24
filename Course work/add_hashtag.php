<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить хэштег</title>
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
        input[type="submit"] {
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            color: white;
            background-color: #008CBA;
            border: none;
            border-radius: 5px;
        }
        label,
        input,
        select {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="header">
        <?php
        session_start();
        if (isset($_SESSION['user_id'])) {
            echo '<a class="action-button blue-link" href="logout.php" onclick="return confirmLogout();">Выйти</a>';
        } else {
            echo '<a class="login-button" href="login.php">Войти</a>';
        }
        ?>
    </div>

    <div style="text-align: center;">
        <fieldset>
            <legend>Добавить хэштег</legend>
            <form action="add_hashtag.php" method="post">
                <label for="hashtag_name">Название хэштега:</label><br>
                <input type="text" id="hashtag_name" name="hashtag_name" required><br><br>
                <label for="field_id">Выберите область знаний:</label><br>
                <select id="field_id" name="field_id" required>
                    <?php
                    $db = new mysqli('localhost', 'root', '', 'sorter');
                    if ($db->connect_error) {
                        die("Ошибка подключения к базе данных: " . $db->connect_error);
                    }

                    $query = "SELECT * FROM Field";
                    $result = $db->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["id_field"] . '">' . $row["name"] . '</option>';
                        }
                    } else {
                        echo '<option value="">Нет доступных областей знаний</option>';
                    }

                    $db->close();
                    ?>
                </select><br><br>
                <input type="submit" value="Добавить хэштег">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $hashtag_name = $_POST['hashtag_name'];
                $field_id = $_POST['field_id'];

                $db = new mysqli('localhost', 'root', '', 'sorter');
                if ($db->connect_error) {
                    die("Ошибка подключения к базе данных: " . $db->connect_error);
                }

                $query = "INSERT INTO Hashtag (name) VALUES ('$hashtag_name')";
                if ($db->query($query) === TRUE) {
                    $hashtag_id = $db->insert_id;
                    $query = "INSERT INTO Field_Hashtag (id_field_hashtag, id_hashtag) VALUES ($field_id, $hashtag_id)";
                    if ($db->query($query) === TRUE) {
                        echo "<p>Хэштег успешно добавлен.</p>";
                    } else {
                        echo "<p>Ошибка: " . $db->error . "</p>";
                    }
                } else {
                    echo "<p>Ошибка: " . $db->error . "</p>";
                }

                $db->close();
            }
            ?>
        </fieldset>
    </div>
</body>

</html>
