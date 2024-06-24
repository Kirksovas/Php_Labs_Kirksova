<?php 
 
namespace View; 
 
class View{ 
    public function __construct(public $path){} 
     
  
    public function renderHtml(string $templateName, $vars = [], int $code=200){ 
        // Установка HTTP-статуса ответа
        http_response_code($code); 
        // Извлечение переменных для доступа в шаблоне
        extract($vars); 
        // Подключение указанного HTML-шаблона
        require($this->path.$templateName); 
    } 
}