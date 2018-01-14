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

?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="styles.css" type="text/css">
   <title>Cookie & Sessions</title>
   
</head>
<body >
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
		</div>
	</div>
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/auth/rabota-s-cookie-na-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>