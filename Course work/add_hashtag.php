<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить хэштег</title>
</head>
<body>
    <h1>Добавить хэштег</h1>
    <form action="add_hashtag.php" method="post">
        <label for="hashtag_name">Название хэштега:</label>
        <input type="text" id="hashtag_name" name="hashtag_name" required>
        <br>
        <label for="field_id">Выберите область знаний:</label>
        <select id="field_id" name="field_id" required>
            <?php
            // Подключение к базе данных
            $db = new mysqli('localhost', 'root', '', 'sorter');
            if ($db->connect_error) {
                die("Ошибка подключения к базе данных: " . $db->connect_error);
            }

            // Получение списка областей знаний для выпадающего списка
            $query = "SELECT * FROM Field";
            $result = $db->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["id_field"] . '">' . $row["name"] . '</option>';
                }
            } else {
                echo '<option value="">Нет доступных областей знаний</option>';
            }

            // Закрытие соединения с базой данных
            $db->close();
            ?>
        </select>
        <br>
        <input type="submit" value="Добавить хэштег">
    </form>

    <?php
    // Обработка отправки формы
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Получение данных из формы
        $hashtag_name = $_POST['hashtag_name'];
        $field_id = $_POST['field_id'];

        // Подключение к базе данных
        $db = new mysqli('localhost', 'пользователь', 'пароль', 'имя_базы_данных');
        if ($db->connect_error) {
            die("Ошибка подключения к базе данных: " . $db->connect_error);
        }

        // Вставка нового хэштега в базу данных
        $query = "INSERT INTO Hashtag (name) VALUES ('$hashtag_name')";
        if ($db->query($query) === TRUE) {
            $hashtag_id = $db->insert_id;
            // Связывание хэштега с областью знаний
            $query = "INSERT INTO Field_Hashtag (id_field_hashtag, id_hashtag) VALUES ($field_id, $hashtag_id)";
            if ($db->query($query) === TRUE) {
                echo "<p>Хэштег успешно добавлен.</p>";
            } else {
                echo "<p>Ошибка: " . $db->error . "</p>";
            }
        } else {
            echo "<p>Ошибка: " . $db->error . "</p>";
        }

        // Закрытие соединения с базой данных
        $db->close();
    }
    ?>
</body>
</html>
