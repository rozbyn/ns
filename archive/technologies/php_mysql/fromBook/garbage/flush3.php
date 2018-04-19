<?php 

header("Connection: close\r\n");
header("Content-Encoding: none\r\n");
ignore_user_abort(true); // optional

echo ('Text user will see');
$size = ob_get_length();
header("Content-Length: $size");
ob_end_flush();     // Strange behaviour, will not work
flush();            // Unless both are called !
ob_end_clean();

//do processing here
sleep(5);

echo('Text user will never see');
//do some processing
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');
$g = file_get_contents('https://www.amazon.com/');


echo $g . '<br>';
file_put_contents('aasd.txt', $g);