<?php
//каждую секунду меняет фон страницы по формуле "текущая секунда" %(остаток от деления) от восьми
//
	$h = date('s');
	
	$img = $h % 8;//\\
	$img = 'backgrounds_img/'.$img.'.jpg';
?>
<!doctype html>
<html>
    <head>
        <title>32432</title>
        <style>
            body{
                background: url(<?php echo $img;?>);
                background-size: cover;
                color: #ff0;
            }
			p {
				text-shadow: 0px 0px 3px white, 3px 3px 3px black;
			}
        </style>
    </head>
    <body>
        <h1><?php echo $h; ?></h1>
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
