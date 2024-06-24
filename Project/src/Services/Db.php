<?php

namespace Services;

class Db {
    private $pdo;
    private static $instance;

    // Закрытый конструктор для предотвращения создания объекта через new
    private function __construct() {
        // Получение настроек базы данных из файла settings.php
        $db = require('settings.php');
        // Создание нового соединения с базой данных с использованием PDO
        $this->pdo = new \PDO(
            'mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
            $db['user'],
            $db['password']
        );
    }

    // Метод для получения единственного экземпляра класса Db (паттерн Singleton)
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // Метод для выполнения SQL-запроса
    public function query(string $sql, $params = [], string $className = 'stdClass'): ?array {
        // Подготовка SQL-запроса
        $sth = $this->pdo->prepare($sql);
        // Выполнение запроса с переданными параметрами
        $result = $sth->execute($params);
        if ($result === false) {
            return null;
        }
        // Возвращаем результат запроса в виде массива объектов указанного класса
        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }
}
