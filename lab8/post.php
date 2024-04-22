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

$lesson = new Lesson('lesson', 'very vush HW', 'hw');
echo $lesson->getTitle();
