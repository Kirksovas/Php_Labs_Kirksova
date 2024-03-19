<?php 
    $znach1 = 'aaab';
    $result1 = preg_replace('/(?<=b)a{3}(?!b)/', '!', $znach1);
    echo $result1; 

    $znach2 = 'aa aba abba abbba abbbba abbbbba';
    $result2 = preg_match_all('/ab{4,}/', $znach2, $matches);
    print_r($matches[0]); 

    $znach3 = 'aba aca aea abba adca abea';
    $result3 = preg_match_all('/a(?=bb|be)ba/', $znach3, $matches);
    print_r($matches[0]);

    $znach4 = 'aae xxz 33a';
    $result4 = preg_replace('/(.)\1/', '!', $znach4);
    echo $result4; 

?>