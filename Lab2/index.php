<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>231-321 Кирксова Кристина</title>
    <style>
        header {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background-color: #f0f0f0; 
        }

        .header__img {
            margin-left: 0;
        }

        .header__title {
            align-items: center;
            margin: 0;
        }
        .header__subtitle {
            text-align: center;
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <img class="header__img"  src="/Lab1/logo.svg" alt="Логотип">
        <h1 class="header__title">Домашняя работа: Solve the equation.</h1>
    </header>
    <main>
    <h2 class="header__subtitle">Вариант №0</h2>
    <?php
    $equation = "X * 9 = 56";

    $section = explode("=", $equation);

    $operands = explode('*', $section[0]);

    $variable = trim($operands[0]) == 'X' ? 'X' : trim($operands[1]);
    
    $value = trim($section[1]);

    $result = intval($value / $operands[1]);

    echo "Значение переменной $variable = $result";
?>
    <h3 class="header__subtitle">Блок-схема:</h2>
    <img src="/Lab2/image/Блок-Схема1.png" alt="Блок-схема">
</main>
<footer>

</footer>
    

</body>
</html>