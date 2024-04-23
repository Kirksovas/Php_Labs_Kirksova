<?php

interface CalculateSquare{
    public function calculateSquare():float;
}

class Rectangle implements CalculateSquare
{
    private $x;
    private $y;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }
    public function calculateSquare(): float
    {
        return $this->x * $this->y;
    }
}
class Square implements CalculateSquare
{
    private $x;

    public function __construct($x)
    {
        $this->x = $x;
    }
    public function calculateSquare(): float
    {
        return $this->x * $this->x;
    }
}

class Circle
{
    const PI = 3.1416;
    private $r;

    public function __construct($r)
    {
        $this->r = $r;
    }
    public function calculateSquare(): float
    {
        return self::PI * ($this->r ** 2);
    }
}

    $rectangle = new Rectangle(3,4);
    echo ($rectangle instanceof CalculateSquare);
    echo($rectangle instanceof Rectangle);

    $circle = new Circle(3);
    var_dump ($circle instanceof CalculateSquare);
    var_dump($circle instanceof Rectangle);

    $square = new Square(6);

    $data = [
        $rectangle,
        $circle,
        $square
    ];

    foreach($data as $elem) {
        if($elem instanceof CalculateSquare){
            echo 'Square = '.$elem->calculateSquare().'<br>';
        } else {
            echo 'Объект класса '.get_class($elem).' не реализует интерфейс CalculateSquare.<br>';
        }
    }
    

