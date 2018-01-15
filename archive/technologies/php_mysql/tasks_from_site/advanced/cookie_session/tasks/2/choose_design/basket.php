<?php
date_default_timezone_set('Europe/Moscow');
session_start();
$goods = [1=>1200, 2=>1400, 3=>1600, 4=>1800, 5=>2000];
if (isset($_POST['buy']) && $_POST['buy']<=5 && $_POST['buy']>=1){
	$_SESSION['buy'][]=$_POST['buy'];
}
$total = 0;
if (isset($_SESSION['buy'])&& !empty($_SESSION['buy'])){
	foreach ($_SESSION['buy'] as $key=>$val){
		$total += $goods[$val];
	}
}
$choosenDesign = 1;
if (isset($_COOKIE['design']) && $_COOKIE['design']>0 && $_COOKIE['design']<7){
	$choosenDesign = $_COOKIE['design'];
	$showChoosenDesign = true;
}
if (isset($_GET['d']) && $_GET['d']>0 && $_GET['d']<7){
	setcookie("design",$_GET['d'], time()+2592000);
	$choosenDesign = $_GET['d'];
	$showChoosenDesign = true;
}
if ($showChoosenDesign){
	$additional_style = '<link rel="stylesheet" href="'.$choosenDesign.'.css" type="text/css">';
}
$chosenStyle=[1=>'','','','','',''];
$chosenStyle[$choosenDesign] = 'class="chosen"';

if (isset($_GET['mail'])){
	$to = 'rozbyn@yandex.ru';
	$subject = 'the TEST';
	$message = 'hello1 hello1 hello1 hello1 hello1 hello1 hello1 hello1 hello1 hello1 ';
	$headers = 'Content-type: text\html;';
	$headers = 'Content-type: text\plain; Charset=utf-8';
	$l = mail($to, $subject, $message, $headers);
	var_dump($l);
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="styles.css" type="text/css">
   <?= $additional_style?>
   <title>Cookie & Sessions</title>
   
</head>
<body>
	<div class="main">
		<div class="wrapper">
			<div class="basket">
				<div class="total">Всего в корзине товаров на сумму<br><?= $total ?> рублей</div>
			</div>
			<div class="goods">
				<div class="product">
					<div class="img" style="background-image: url('img/1 (1).jpg');"></div>
					<div class="price">1200р</div>
					<div class="add">
						<form action="" method="POST">
							<input type="hidden" value="1" name="buy">
							<input type="submit" value="Купить">
						</form>
					</div>
				</div>
			<div class="product">
					<div class="img" style="background-image: url('img/1 (2).jpg');"></div>
					<div class="price">1400р</div>
					<div class="add">
						<form action="" method="POST">
							<input type="hidden" value="2" name="buy">
							<input type="submit" value="Купить">
						</form>
					</div>
				</div>
			<div class="product">
					<div class="img" style="background-image: url('img/1 (3).jpg');"></div>
					<div class="price">1600р</div>
					<div class="add">
						<form action="" method="POST">
							<input type="hidden" value="3" name="buy">
							<input type="submit" value="Купить">
						</form>
					</div>
				</div>
			<div class="product">
					<div class="img" style="background-image: url('img/1 (4).jpg');"></div>
					<div class="price">1800р</div>
					<div class="add">
						<form action="" method="POST">
							<input type="hidden" value="4" name="buy">
							<input type="submit" value="Купить">
						</form>
					</div>
				</div>
			<div class="product">
					<div class="img" style="background-image: url('img/1 (5).jpg');"></div>
					<div class="price">2000р</div>
					<div class="add">
						<form action="" method="POST">
							<input type="hidden" value="5" name="buy">
							<input type="submit" value="Купить">
						</form>
					</div>
				</div>
			</div>
			<div class="total">Всего в корзине товаров на сумму<br><?= $total ?> рублей</div>
			<div class="choose_design">
				<div class="design" style="background: #fff;"><a href="?d=1" <?=$chosenStyle[1]?> ></a></div><div
				 class="design" style="background: #fff300;"><a href="?d=2" <?=$chosenStyle[2]?> ></a></div><div
				 class="design" style="background: #18ff00;"><a href="?d=3" <?=$chosenStyle[3]?> ></a></div><div
				 class="design" style="background: #00ffed;"><a href="?d=4" <?=$chosenStyle[4]?> ></a></div><div
				 class="design" style="background: #001eff;"><a href="?d=5" <?=$chosenStyle[5]?> ></a></div><div
				 class="design" style="background: red"><a href="?d=6" <?=$chosenStyle[6]?> ></a></div>
			</div>
			<a href="?mail=1">mail</a>
		</div>
	</div>
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/auth/rabota-s-cookie-na-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>