<?php
session_start();

$db = new mysqli('localhost', 'root', '', 'sorter');
if ($db->connect_error) {
    die("Ошибка подключения к базе данных: " . $db->connect_error);
}

$query = "SELECT * FROM Hashtag";
$result = $db->query($query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['hashtag_id'])) {
        $hashtag_id = $_POST['hashtag_id'];
        
        $delete_field_hashtag_query = "DELETE FROM Field_Hashtag WHERE id_hashtag = $hashtag_id";
        if ($db->query($delete_field_hashtag_query) === TRUE) {
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

$db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Удалить хэштег</title>
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
        if (isset($_SESSION['user_id'])) {
            echo '<a class="action-button blue-link" href="logout.php" onclick="return confirmLogout();">Выйти</a>';
        } else {
            echo '<a class="login-button" href="login.php">Войти</a>';
        }
        ?>
    </div>
    <h1>Удалить хэштег</h1>

    <?php if (isset($success_message)) : ?>
        <div style="color: green;"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)) : ?>
        <div style="color: red;"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="post">
        <fieldset>
            <legend>Выберите хэштег для удаления:</legend>
            <select name="hashtag_id">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <option value="<?php echo $row['id_hashtag']; ?>"><?php echo $row['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <br><br>
            <input type="submit" value="Удалить хэштег">
        </fieldset>
    </form>
</body>

</html>
