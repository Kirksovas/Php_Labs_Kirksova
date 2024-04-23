<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <style>
        .register-form {
            margin: 50px auto;
            width: 300px;
            text-align: center;
        }

        .submit-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Регистрация</h1>
    <div class="register-form">
        <form action="register.php" method="post">
            <label for="name">Имя:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Зарегистрироваться" class="submit-button">
        </form>
    </div>
</body>
</html>
