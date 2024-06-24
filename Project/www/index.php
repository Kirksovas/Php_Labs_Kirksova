<?php
// Автозагрузка классов при их использовании
    spl_autoload_register(function (string $className){
        // Преобразование имени класса в путь к файлу
        require_once('../src/'.str_replace('\\', '/',$className).'.php');
    });
    // создание объектов класса
    $user = new Models\Users\User();
    $article = new Models\Articles\Article();
    // Получение маршрута из URL параметра 'route', если он существует, иначе пустая строка
    $route = $_GET['route'] ?? '';
    $routes = require('../src/routes.php'); //подключение
    $pageFound = false;  //отслеживание маршрута
    // Проход по каждому маршруту и его сопоставление с текущим маршрутом
    foreach ($routes as $pattern=>$controllerAndAction){
        preg_match($pattern, $route, $matches);
        if(!empty($matches)){
            // Удаление полного совпадения из массива результатов
            unset($matches[0]); 
            $pageFound = true; // Пометка что страница найдена
            $actionName = $controllerAndAction[1]; // Получение действия (метода) из массива
            $controller = new $controllerAndAction[0]; // Создание нового экземпляра контроллера
            $controller->$actionName(...$matches); // Вызов метода действия с захваченными параметрами $matches
         }
    }
    // Если ни один маршрут не подошел, вывод сообщения "Страница не найдена"
    if (!$pageFound) echo 'Страница не найдена';