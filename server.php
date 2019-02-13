<?php

session_start();

$con = mysqli_connect('localhost','root','','gamedatabase');

$con ->set_charset('utf8');

$errors = array();

if(!$con){
    echo 'ბაზასთან დაკავშირება ვერ ხერხდება !!!';
}

?>