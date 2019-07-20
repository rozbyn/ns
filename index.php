<?php
$metricaHtml = include_once $_SERVER['DOCUMENT_ROOT'] . '/config/yandexMetrika.php';


?>


<!DOCTYPE html>
<html lang="ru">
<head>
	
	
    <meta charset="UTF-8">
    <title>rozbyn.site</title>
		<?=$metricaHtml?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="reset.css" type="text/css">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <link rel="icon" href ="favicon.ico" type= "image/x-icon" >
    <link rel="shortcut icon" href ="favicon.ico" type="image/x-icon" >

</head>
<body>
    <div class="main">
        <h1>rozbyn.site</h1>
        <!--
        <h5></h5>
        <h6></h6>
        <h7></h7>
        <h8></h8>
        <h9></h9>
        -->
        <div class="text">

            <p>Здравствуйте. Меня зовут Роман и это мой сайт. В данный момент я активно изучаю веб-программирование.</p>
            <p>Программирование всегда привлекало меня, начиная со школы, но вплотную им заниматься мне так и не удавалось. До лета 2017 года.</p>
            <p>На этом сайте разместились почти все мои наработки, сделанные по ходу жизни на разных должностях. Начиная от работы риелтором (создание электронной базы клиентов с формами и отчетами) заканчивая оператором цифровой печати (макросы в CorelDraw  и Excel для упрощения и ускорения рабочих процессов).</p>
            <p>В дальнейшем здесь я буду размещать свои файлы, написанные по ходу изучения веб-технологий, таких как HTML, CSS, JAVASCRIPT, PHP, MYSQL.</p>
            <p> <a href="mailto:rozbyn@yandex.ru">rozbyn@yandex.ru</a> 
        		<span style="float: right">
        			<a href="archive/">Архив</a>
        		</span>
            	<!-- <span style="float: right">
            		<a href="https://inseverable-zero.000webhostapp.com/">Копия сайта</a>
            	</span> -->
            </p>
        </div>
    </div>
    <div class="circle">

    </div>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>