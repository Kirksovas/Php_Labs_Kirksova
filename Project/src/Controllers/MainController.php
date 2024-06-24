<?php

namespace Controllers;
use View\View;

    class MainController{
        public $view;
        // Конструктор, инициализирующий свойство view
        public function __construct(){
            $this->view = new View(__DIR__.'/../../templates/');
        }
        // Метод для отображения главной страницы
        public function main(){
            $this->view->renderHtml('main/main.php');
        }
        // Метод для отображения страницы приветствия с указанным именем
        public function sayHello(string $name){
            $this->view->renderHtml('main/hello.php',['name' => $name]);
        }
    }