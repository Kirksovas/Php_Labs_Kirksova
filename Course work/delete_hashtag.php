<?php
session_start();

// Подключение к базе данных
$db = new mysqli('localhost', 'root', '', 'sorter');
if ($db->connect_error) {
    die("Ошибка подключения к базе данных: " . $db->connect_error);
}

// Получение списка всех хэштегов
$query = "SELECT * FROM Hashtag";
$result = $db->query($query);

// Обработка формы удаления хэштега
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, был ли передан идентификатор хэштега для удаления
    if (isset($_POST['hashtag_id'])) {
        $hashtag_id = $_POST['hashtag_id'];
        
        // Удаление связанных записей из таблицы Field_Hashtag
        $delete_field_hashtag_query = "DELETE FROM Field_Hashtag WHERE id_hashtag = $hashtag_id";
        if ($db->query($delete_field_hashtag_query) === TRUE) {
            // Удаление самого хэштега из таблицы Hashtag
            $delete_hashtag_query = "DELETE FROM Hashtag WHERE id_hashtag = $hashtag_id";
            if ($db->query($delete_hashtag_query) === TRUE) {
                $success_message = "Хэштег успешно удален.";
            } else {
                $error_message = "Ошибка при удалении хэштега: " . $db->error;
            }
        } else {
            $error_message = "Ошибка при удалении связанных записей: " . $db->error;
        }
    } else {
        $error_message = "Не удалось получить идентификатор хэштега для удаления.";
    }
}

// Закрытие соединения с базой данных
$db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Удалить хэштег</title>
</head>

<body>
    <h1>Удалить хэштег</h1>

    <?php if (isset($success_message)) : ?>
        <div style="color: green;"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)) : ?>
        <div style="color: red;"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="post">
        <p>Выберите хэштег для удаления:</p>
        <select name="hashtag_id">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <option value="<?php echo $row['id_hashtag']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <br><br>
        <input type="submit" value="Удалить хэштег">
    </form>
</body>

</html>
