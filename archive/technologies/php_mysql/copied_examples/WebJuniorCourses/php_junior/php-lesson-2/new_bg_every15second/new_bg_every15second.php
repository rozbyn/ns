<?php
	$h = date('s');
	
	// $img = (int)($h / 6);
	$img = ($h / 15) - ($h % 15 / 15);
	$img = 'img/'.$img.'.jpg';
	
?>
<!doctype html>
<html>
    <head>
        <title>32432</title>
        <style>
            body{
                background: url(<?= $img;?>);
                background-size: cover;
                color: #ff0;
            }
        </style>
    </head>
    <body>
        <h1><?= $h; ?></h1>
        <h1><?= $img; ?></h1>
        <p>Some text, some text</p>
        <p>Some text, some text</p>
        <p>Some text, some text</p>
        <p>Some text, some text</p>
        <p>Some text, some text</p>
        <p>Some text, some text</p>
        <p>Some text, some text</p>
        <p>Some text, some text</p>
        <p>Some text, some text</p>
        <p>Some text, some text</p>
        <p>Some text, some text</p>
        <p>Some text, some text</p>
        <p>Some text, some text</p>
    </body>
</html>
