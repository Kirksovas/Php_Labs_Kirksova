<?php

    namespace Models;
    use Services\Db;


    abstract class ActiveRecordEntity{
        protected $id;
        // Преобразует строку в формат CamelCase
        private function formatUppercaseToCamelcase(string $key): string
        {
            return lcfirst(str_replace('_', '', ucwords($key, '_')));
        }
        // Преобразует строку в формат для использования в бд
        private function formatToDb(string $key){
            return strtolower(preg_replace('/([A-Z])/', '_$1', $key));
        }
        // Метод для установки значений свойств
        public function __set($key, $value){
            $property = $this->formatUppercaseToCamelcase($key);
            $this->$property = $value;
        }
        // Геттер для получения идентификатора сущности
        public function getId(){
            return $this->id;
        }
        // Получение пар свойств и их значений для использования в запросах к бд
        public function getPropertyToDb(): array
        {
            $reflector = new \ReflectionObject($this);
            $properties = $reflector->getProperties();
            $nameAndValue = [];
            foreach($properties as $property){
                $propertyName = $property->getName();
                $propertyNameToDb = $this->formatToDb($property->getName());
                $nameAndValue[$propertyNameToDb] = $this->$propertyName;
            }
            return $nameAndValue;
        }
        // Метод для поиска всех записей сущности в бд
        public static function findAll(): ?array
        {
            $db = Db::getInstance();
            $sql = 'SELECT * FROM `'.static::getTableName().'`';
            return $db->query($sql, [], static::class);
        }
        // Метод для поиска сущности по идентификатору
        public static function getById(int $id): ?self
        {
            $db = Db::getInstance();
            $sql = 'SELECT * FROM `'.static::getTableName().'` WHERE `id`='.$id;
            $entyties = $db->query($sql, [], static::class);
            return $entyties ? $entyties[0] : null;
        }
        // Метод для получения значения определенного поля сущности по идентификатору
        public static function getFieldById(string $field, int $id): ?self
        {
            $db = Db::getInstance();
            $sql = 'SELECT `'.$field.'` FROM `'.static::getTableName().'` WHERE `id`='.$id;
            $entyties = $db->query($sql, [], static::class);
            return $entyties ? $entyties[0] : null;
        }
        // Метод для сохранения сущности в бд
        public function save(){
            if ($this->getId()) $this->update();
            else $this->insert();
        }
        // Метод для вставки новой записи в бд
        public function insert(){
            $db = Db::getInstance();
            $propertiesAndValues = array_filter($this->getPropertyToDb());
            $params = [];
            $parameter = [];
            $paramToValue = [];
            foreach($propertiesAndValues as $property=>$value){
                $param = ':'.$property;
                $params[] = '`'.$property.'`';
                $parameter [] = $param;
                $paramToValue[$param] = $value;
            }

            $sql = 'INSERT INTO `'.static::getTableName().'`
                    ('.implode(',', $params).') VALUES ('.implode(',', $parameter).')';
            $db->query($sql, $paramToValue, static::class);
        }
        // Метод для обновления существующей записи в бд
        public function update(){
            $db = Db::getInstance();
            $propertiesAndValues = $this->getPropertyToDb();
            $paramToValue = [];
            $params = [];
            foreach($propertiesAndValues as $property=>$value){
                $param = ':'.$property;
                $params[] = '`'.$property.'`=:'.$property;
                $paramToValue[$param] = $value;
            }
            $sql = 'UPDATE `'.static::getTableName().'` SET '.implode(',',$params).' WHERE `id`=:id';
            $db->query($sql, $paramToValue, static::class);
        }
        // Метод для удаления сущности из базы данных
        public function delete(){
            $db = Db::getInstance();
            $sql = 'DELETE FROM `'.static::getTableName().'` WHERE `id`=:id';
            $db->query($sql, [':id'=>$this->id], static::class);
        }
        // Абстрактный метод для получения имени таблицы в базе данных
        abstract protected static function getTableName();
    }