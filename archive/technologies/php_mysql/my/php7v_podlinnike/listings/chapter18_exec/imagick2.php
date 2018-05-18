<?php header("Content-type: image/jpeg");
echo(file_get_contents("./ima/".mt_rand(1, 8).".jpg"));
file_put_contents('test', 'text text text text text text text text text text text ')