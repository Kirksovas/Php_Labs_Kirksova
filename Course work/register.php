<?php
// Подключение к базе данных
$db = new mysqli('localhost', 'root', '', 'sorter');
if ($db->connect_error) {
    die("Ошибка подключения к базе данных: " . $db->connect_error);
}

// Проверяем, были ли данные отправлены методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Хешируем пароль перед сохранением в базу данных (рекомендуется использовать более безопасные методы хеширования)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Подготавливаем запрос для вставки данных пользователя в таблицу Users
    $stmt = $db->prepare("INSERT INTO Users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    // Выполняем запрос
    if ($stmt->execute()) {
        // Если запрос выполнен успешно, перенаправляем пользователя на страницу авторизации с уведомлением о успешной регистрации
        header("Location: login.php?registration_success=true");
        exit;
    } else {
        // Если произошла ошибка при выполнении запроса, выводим сообщение об ошибке
        echo "Ошибка при регистрации пользователя: " . $stmt->error;
    }

    // Закрываем подготовленное выражение и соединение с базой данных
    $stmt->close();
    $db->close();
}
?>
