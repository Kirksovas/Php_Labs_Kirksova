<?php
class Post
{
    protected $title;
    protected $text;

    public function __construct(string $title, string $text)
    {
        $this->title = $title;
        $this->text = $text;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function setText(string $text): void
    {
        $this->text = $text;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getText()
    {
        return $this->text;
    }
}
class Lesson extends Post
{
    private $homeWork;

    public function __construct(string $title, string $text, string $homeWork)
    {
        parent::__construct($title, $text);
        $this->homeWork = $homeWork;
    }

    public function setHomeWork(string $homeWork):void {
        $this->homeWork = $homeWork;
    }
    public function getHomeWork ():string {
        return $this->homeWork;
    }
}

class PaidLesson extends Lesson
{
    private $price;

    public function __construct(string $title, string $text, string $homeWork, float $price)
    {
        parent::__construct($title, $text, $homeWork);
        $this->price = $price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}

$paidLesson = new PaidLesson('Урок о наследовании в PHP', 'Лол, кек, чебурек', 'Ложитесь спать, утро вечера мудренее', 99.90);
var_dump($paidLesson);

?>
