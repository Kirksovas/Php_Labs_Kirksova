<?php

class Cat {
    private $name;
    private $color;

    public function __construct($name, $color) {
        $this->name = $name;
        $this->color = $color;
    }

    public function sayHello() {
        echo "Здравствуйте! Меня зовут {$this->name}! Моя шерстка такого вот цвета - {$this->color}. Замурчательно познакомиться!". "<br>";
    }

    public function getColor() {
        return $this->color."<br>";
    }
}

$cat1 = new Cat("Пельмешка", "белый");
$cat2 = new Cat("Тапок", "рыжий");

$cat1->sayHello();
$cat2->sayHello();

echo $cat1->getColor();
echo $cat2->getColor();
?>