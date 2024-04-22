<?php
// Начинаем сессию
session_start();

// Разрушаем все данные сессии
$_SESSION = array();

// Если требуется уничтожение cookie-файла, также можно удалить cookie сессии
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Уничтожаем сессию
session_destroy();

// Перенаправляем пользователя на страницу index.php
header("Location: index.php");
exit;
?>
