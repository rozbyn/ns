<?php
$metricaHtml = include $_SERVER['DOCUMENT_ROOT'] . '/Config/yandexMetrika.php';


?>


<!DOCTYPE html>
<html lang="ru">
<head>
    
    
    <meta charset="UTF-8">
    <title>test1</title>
        <?=$metricaHtml?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="reset.css" type="text/css">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <link rel="icon" href ="favicon.ico" type= "image/x-icon" >
    <link rel="shortcut icon" href ="favicon.ico" type="image/x-icon" >

</head>
<body>
    <div class="main">
    </div>
    <div class="circle">

    </div>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
