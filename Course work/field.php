<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Выбранная область</title>
    <style>
        .header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: right;
        }

        .center-content {
            text-align: center;
            margin-top: 50px;
        }

        .hashtag-list {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .hashtag-list li {
            margin: 5px;
        }

        .hashtag-list li a {
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f0f0f0;
            transition: background-color 0.3s ease;
        }

        .hashtag-list li a:hover {
            background-color: #e0e0e0;
        }
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

    <div class="center-content">
        <?php
        $field_name = $_GET['field'] ?? '';

        echo '<div class="field-name">' . $field_name . '</div>';

        $db = new mysqli('localhost', 'root', '', 'sorter');
        if ($db->connect_error) {
            die("Ошибка подключения к базе данных: " . $db->connect_error);
        }

        $query_hashtags = "SELECT Hashtag.id_hashtag, Hashtag.name FROM Hashtag 
        INNER JOIN Field_Hashtag ON Hashtag.id_hashtag = Field_Hashtag.id_hashtag
        WHERE Field_Hashtag.id_field_hashtag = (SELECT id_field FROM Field WHERE name = '$field_name')";


        $result_hashtags = $db->query($query_hashtags);

        if ($result_hashtags && $result_hashtags->num_rows > 0) {
            echo '<ul class="hashtag-list">';
            while ($row_hashtag = $result_hashtags->fetch_assoc()) {
                echo '<li><a href="hashtags.php?hashtag=' . $row_hashtag['id_hashtag'] . '">' . $row_hashtag['name'] . '</a></li>';
            }
            echo '</ul>';
        } else {
            echo "Нет хештегов для выбранной области";
        }

        $db->close();
        ?>
    </div>
</body>

</html>
