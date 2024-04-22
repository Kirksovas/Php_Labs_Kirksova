<?php
    class A{
        public function sayHello(){
            return 'Hello, I am A';
        }
    }

    $a = new A;
    var_dump ($a instanceof A);

    class B extends A {

    }

    $b = new B;
    var_dump($b instanceof A);
    echo '<br>';
    var_dump($b instanceof A);

