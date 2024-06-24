<?php
namespace Models\Articles;

use Models\ActiveRecordEntity;
use Services\Db;

class Article extends ActiveRecordEntity{
            // Свойства, представляющие поля статьи в базе данных
            protected $name;
            protected $text;
            protected $authorId;
            protected $createdAt;
            // Прописываем геттеры и сеттеры
            public function getName(){
                return $this->name;
            }
            public function getText(){
                return $this->text;
            }
            public function getAuthorId(){
                return $this->authorId;
            }
            public function setName(string $name){
                $this->name = $name;
            }
            public function setText(string $text){
                $this->text = $text;
            }
            public function setAuthorId(string $authorId){
                $this->authorId = $authorId;
            }
            // Метод для получения статьи по её идентификатору из базы данных
            public static function getById(int $id): ?self
            {
                // Получаем экземпляр соединения с базой данных
                $db = Db::getInstance();
                // Формируем SQL-запрос для получения статьи по идентификатору
                $sql = 'SELECT * FROM `'.static::getTableName().'` WHERE `id`='.$id;
                // Выполняем запрос и возвращаем результат в виде массива объектов Article
                $entyties = $db->query($sql, [], static::class);
                return $entyties ? $entyties[0] : null;
            }
            // Метод для получения значения указанного поля статьи по её идентификатору
            public static function getFieldById(string $field, int $id): ?self
            {
                $db = Db::getInstance();
                $sql = 'SELECT `'.$field.'` FROM `'.static::getTableName().'` WHERE `id`='.$id;
                $entyties = $db->query($sql, [], static::class);
                return $entyties ? $entyties[0] : null;
            }
            // Метод для получения имени таблицы статей в базе данных
            protected static function getTableName(){
                return 'articles';
            }
    }