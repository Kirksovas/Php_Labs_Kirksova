<?php
// Начинаем сессию
session_start();

// Подключение к базе данных
$db = new mysqli('localhost', 'root', '', 'sorter');
if ($db->connect_error) {
    die("Ошибка подключения к базе данных: " . $db->connect_error);
}

// Проверка наличия данных в запросе POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем введенные пользователем данные
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Подготавливаем запрос для получения данных пользователя из базы данных
    $stmt = $db->prepare("SELECT id_users, password FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Выполняем запрос
    $stmt->execute();
    $stmt->store_result();

    // Проверяем, найден ли пользователь с указанным email
    if ($stmt->num_rows > 0) {
        // Связываем результаты запроса
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Проверяем, совпадает ли введенный пароль с хешированным паролем из базы данных
        if (password_verify($password, $hashed_password)) {
            // Если пароль совпадает, устанавливаем сессию для пользователя
            $_SESSION['user_id'] = $user_id;

            // Перенаправляем пользователя на index.php после успешной авторизации
            header("Location: index.php");
            exit;
        } else {
            // Если пароль не совпадает, выводим сообщение об ошибке и дополнительные сведения
            echo "Неверный email или пароль. Пожалуйста, свяжитесь с администратором для получения дополнительной помощи.";
            echo "<br>";
            echo "Email: " . $email;
            echo "<br>";
            echo "Хешированный пароль в базе данных: " . $hashed_password;
        }
    } else {
        // Если пользователь с указанным email не найден, выводим сообщение об ошибке
        echo "Неверный email или пароль";
    }

    // Закрываем запрос и соединение с базой данных
    $stmt->close();
    $db->close();
} else {
    // Если данные не были отправлены методом POST, перенаправляем на страницу авторизации
    header("Location: login.php");
    exit;
}
?>
