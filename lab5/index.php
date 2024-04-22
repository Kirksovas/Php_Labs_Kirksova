<?php
    $string = 'aba aca aea abba adca abea';
    $result = preg_match_all('/\b(?:abba|abea)\b(?!dca)/', $string, $matches);
    print_r($matches[0]); 
?>