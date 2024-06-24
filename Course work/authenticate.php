<?php
// Начинаем сессию
session_start();

// Подключение к базе данных
$db = new mysqli('localhost', 'root', '', 'sorter');
if ($db->connect_error) {
    die("Ошибка подключения к базе данных: " . $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $db->prepare("SELECT id_users, password FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {

        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;

            header("Location: index.php");
            exit;
        } else {
            echo "Неверный email или пароль. Пожалуйста, свяжитесь с администратором для получения дополнительной помощи.";
            echo "<br>";
            echo "Email: " . $email;
            echo "<br>";
            echo "Хешированный пароль в базе данных: " . $hashed_password;
        }
    } else {

        echo "Неверный email или пароль";
    }

    $stmt->close();
    $db->close();
} else {
    header("Location: login.php");
    exit;
}
?>
