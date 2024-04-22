<?php

    class Cat {
        public $name;
        private $color;
        public $width;

        public function __construct(string $name='Murka', string $color='black', int $width=3)
        {
            $this->name = $name;
            $this->color = $color;
            $this->width = $width;
        }

        public function sayHello(){
            return 'My name is '.$this->name;
        }

        public function setColor(string $color) {
            if ($color == 'white' || $color == 'black'){
                $this->color = $color;
            }
            else return 'You enter wrong color!';
        }

        public function getColor():string
        {
            return $this->color;
        }
    }

    $cat = new Cat ('Mashka', 'white', 5);
    var_dump($cat);
    echo '<br>';
    
    $cat->name = 'Murka';
    $cat->setColor('black');
    $cat->width = 3;
    echo $cat->getColor();
    

    $cat1 = new Cat;
    $cat1->name = 'Barsik';
    $cat1->setColor('white');
    $cat1->width = 3;
    echo $cat1->sayHello();
