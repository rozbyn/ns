Здравствуйте!<br>
<a  href="enter.php">Вход</a><br>
<a  href="register.php">Регистрация</a><br>
<?php
$article = 'photos';
$page = 'myphoto';



if (empty($_GET)){
	
	echo 'Не передано значение GET.' . '<br>';
} elseif (empty($_GET['article']) || empty($_GET['page'])) {
	
	echo 'Одно из значений GET пустое.' . '<br>';
} else {
	$article = $_GET['article'];
	$page = $_GET['page'];
	if(is_file("files/articles/$article/$page.txt")){
		echo "Показана страница $article/$page.txt." . '<br>';
		include("files/articles/$article/$page.txt");
		
		
	} else {
		echo 'Нет такой страницы' . '<br>';
	}
}

?>
</br>
<a  href="index.php?article=news&page=today">Новости - сегодня</a><br>
<a  href="index.php?article=news&page=tomorrow">Новости - завтра</a><br>
<a  href="index.php?article=photos&page=myphoto">Фото - моё фото</a><br>
<a  href="index.php?article=photos&page=theyphoto">Фото - их фото</a><br>
<a  href="index.php?article=price&page=badprice">Цены - плохая цена</a><br>
<a  href="index.php?article=price&page=goodprice">Цены - хорошая цена</a><br>

<!--files/articles/news/today.txt
files/articles/news/tomorrow.txt
files/articles/photos/myphoto.txt
files/articles/photos/theyphoto.txt
files/articles/price/badprice.txt
files/articles/price/goodprice.txt-->
