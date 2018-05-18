<?php

//$pic = "E:\rmz\media\615242091.jpg";
header("Content-type: image/jpeg");

//$asd = exec('"E:\Program Files\ImageMagick-6.9.3-Q16\convert.exe" -blur 3 "E:\rmz\media\615242091.jpg" -');
passthru('"E:\Program Files\ImageMagick-6.9.3-Q16\convert.exe" -blur 3 "E:\rmz\media\615242091.jpg" -');
