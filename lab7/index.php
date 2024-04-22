<?php
if(isset($_COOKIE['visit'])) {
    $visit = $_COOKIE['visit'] + 1;
} else {
    $visit = 1;
}

setcookie("visit", $visit, time() + (86400 * 1), "/");

echo "Вы посетили наш сайт $visit раз/а!";
?>
