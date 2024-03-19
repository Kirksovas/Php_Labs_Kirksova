<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>231-321 Кирксова Кристина</title>
    <style>
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background-color: #f0f0f0; 
        }

        .header__img {
            margin-left: 0;
        }

        .header__title {
            text-align: center;
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <img class="header__img"  src="/Lab1/logo.svg" alt="Логотип">
        <h1 class="header__titlw">Домашняя работа: Hello, World!</h1>
    </header>
    <main>
    <?php
$file = 'test.txt';
$folder = 'dir/';

if (copy($file, $folder . 'test.txt')) {
if (unlink($file)) {
echo "Файл успешно перемещен в папку 'dir'.";
} else {
echo "Произошла ошибка при удалении исходного файла.";
}
} else {
echo "Произошла ошибка при перемещении файла в папку 'dir'.";
}
?>
    </main>
    <footer>

    </footer>
    

</body>
</html>