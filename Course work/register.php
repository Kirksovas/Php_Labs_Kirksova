<?php
$db = new mysqli('localhost', 'root', '', 'sorter');
if ($db->connect_error) {
    die("Ошибка подключения к базе данных: " . $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO Users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        header("Location: login.php?registration_success=true");
        exit;
    } else {
        echo "Ошибка при регистрации пользователя: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
}
?>
