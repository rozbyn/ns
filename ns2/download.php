<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/autoload.php';

function make_table($headTable = ['#', 'name', 'count', 'something'], $arrOfData = [[1, 'lolol', 33, 'what?'], [2, 'komomo', 99, 'nowhere']]){
	$table = '';
	$table .= '<table><thead>';
	foreach ($headTable as $val){
		$table .=  '<td>' . $val . '</td>';
	}
	$table .=  '</thead>';
	$table .=  '<tbody>';
	foreach ($arrOfData as $record){
		$table .=  '<tr>';
		foreach($record as $val){
			$table .=  '<td>' . $val . '</td>';
		}
		$table .=  '</tr>';
	}
	$table .=  '</tbody>';
	$table .=  '</table>';
	return $table;
}
///////////////
if (!isset($_COOKIE['dlJniPaZps']) || $_COOKIE['dlJniPaZps']!=='Njk5HhpI4u'){
	exit('Только для АДМИНОВ!!!');
}

$myDbObj = \RozbynDev\Db\Mysqli::getObj();
echo '<a href=".">На главную</a>' . '<br>';


if(isset($_POST['send_img'])){
	$uploaddir = "./img/";
	if(!empty($_POST['folder'])){
		$uploaddir .= trim($_POST['folder'], '/') . '/';
		if(!is_dir($uploaddir)){
			if(mkdir($uploaddir, 0777, true)){
				echo 'Папка успешно создана' . '<br>';
			} else {
				echo 'Не удалось создать папку' . '<br>';
				exit();
			}
		}
	}
	if (is_array($_FILES['userfile']['name'])){
		$countFiles = count($_FILES['userfile']['name'])-1;
		for($i=0;$i<=$countFiles;$i++){
			$uploadfile = $uploaddir . basename($_FILES['userfile']['name'][$i]);

			if (move_uploaded_file($_FILES['userfile']['tmp_name'][$i], $uploadfile)) {
				echo '+1 ';
			} else {
				echo "Файл не загружен!<br>";
			}
		}
	}
		
}
if (isset($_POST['send_goods_csv'])){
	$uploaddir = './csv/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		echo "Файл корректен и был успешно загружен.<br>";
	} else {
		echo "Файл не загружен!<br>";
	}
	$csvArr = [];
	if (($handle = fopen("$uploadfile", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
			if(count($data) !=7){exit('Ошибка в данных CSV!');}
			$csvArr[] = $data;
		}
		fclose($handle);
	}
	$query = 'INSERT INTO shop_goods (id, category, name, pack, price, img, showOnMain) VALUES';
						'("Дима", 23, 400),
						("Петя", 25, 500), 
						("Вася", 23, 500), 
						("Коля", 30, 1000), 
						("Иван", 27, 500), 
						("Кирилл", 28, 1000)';
	foreach($csvArr as $key=>$val){
		$query .= '(';
		foreach($val as $value){
			$query .= '\''.$myDbObj->escape_string($value).'\',';
		}
		$query = substr($query,0,-1);
		$query .= '),';
	}
	$query = substr($query,0,-1);
	if($myDbObj->query($query)){
		echo 'Данные успешно занесены в базу данных' . '<br>';
	} else {
		echo 'Ошибка записи данных в БД!' . '<br>';
		echo $myDbObj->error . '<br>';
	}
}




if (isset($_POST['send_cat_csv'])){
	$uploaddir = './csv/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		echo "Файл корректен и был успешно загружен.<br>";
	} else {
		echo "Файл не загружен!<br>";
	}
	$csvArr = [];
	if (($handle = fopen("$uploadfile", "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
			if(count($data) !=5){exit('Ошибка в данных CSV!');}
			$csvArr[] = $data;
		}
		fclose($handle);
	}
	$query = 'INSERT INTO shop_categories (id, parentCat, name, priceCat, unit) VALUES';
						'("Дима", 23, 400),
						("Петя", 25, 500), 
						("Вася", 23, 500), 
						("Коля", 30, 1000), 
						("Иван", 27, 500), 
						("Кирилл", 28, 1000)';
	foreach($csvArr as $key=>$val){
		$query .= '(';
		foreach($val as $value){
			$query .= '"'.$myDbObj->escape_string($value).'",';
		}
		$query = substr($query,0,-1);
		$query .= '),';
	}
	$query = substr($query,0,-1);
	if($myDbObj->query($query)){
		echo 'Данные успешно занесены в базу данных' . '<br>';
	} else {
		echo 'Ошибка записи данных в БД!' . '<br>';
	}
}

echo '<pre>';
//print_r($csvArr);
echo '</pre>';


//меняем категории в базе---------
if(isset($_POST['subm']) && is_numeric($_POST['subm'])){
	if(isset($_POST['id']) && is_numeric($_POST['id'])){
		$id2 = $_POST['id'];
	} else {
		$id2 = $_POST['subm'];
	}
	$query = "UPDATE shop_categories SET id=?, parentCat=?, name=?, priceCat=?, unit=? WHERE id=?";
	$stmt = $myDbObj -> prepare($query);
	$stmt -> bind_param('iisssi', $id2, $_POST['parentCat'], $_POST['name'], $_POST['priceCat'], $_POST['unit'], $_POST['subm']);
	if($stmt->execute()){
		echo 'Всё ОК!' . '<br>';
	} else {
		echo 'ОШИБКА!!!' . '<br>';
	}
	$stmt->close();
}

//меняем категории в базе---------




//выводим категории------
$query = "SELECT id, parentCat, name, priceCat, unit FROM shop_categories";
$stmt = $myDbObj->prepare($query);
$stmt->execute();
$stmt->bind_result($id, $parentCat, $name, $priceCat, $unit);
$arr = [];
for($i=0;$stmt->fetch();$i++){
	$arr[$i]['id']=$id;
	$arr[$i]['parentCat']=$parentCat;
	$arr[$i]['name']=$name;
	$arr[$i]['priceCat']=$priceCat;
	$arr[$i]['unit']=$unit;
}
$stmt->close();
$cat='';
$cat.='<form action="" method="">';
$cat.='<input value="id" disabled>';
$cat.='<input value="parentCat" disabled>';
$cat.='<input value="name" disabled>';
$cat.='<input value="priceCat" disabled>';
$cat.='<input value="unit" disabled>';
$cat.='</form><br>';
foreach($arr as $category){
	$cat.='<form action="" method="POST">';
	$cat.='<input type="text" name="id" value=\'' . $category['id'] . '\' disabled >';
	$cat.='<input type="text" name="parentCat" value=\'' . $category['parentCat'] . '\'>';
	$cat.='<input type="text" name="name" value=\'' . $category['name'] . '\'>';
	$cat.='<input type="text" name="priceCat" value=\'' . $category['priceCat'] . '\'>';
	$cat.='<input type="text" name="unit" value=\'' . $category['unit'] . '\'>';
	$cat.='<button type="submit" name="subm" value=\''.$category['id'].'\' style="display:none;"></button>';
	$cat.='</form><br>';
}
//выводим категории------








?>

<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="reset.css" type="text/css"/>
   <link rel="stylesheet" href="styles.css" type="text/css"/>
   <title>Загрузка файлов"</title>
</head>
<body >
<div class="main">
	<div class="wrapper">
		<form enctype="multipart/form-data" action="" method="POST">
			Положить в папку <input type="text" name="folder" /><br>
			<!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
			<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
			<!-- Название элемента input определяет имя в массиве $_FILES -->
			Загрузить картинки: <input name="userfile[]" type="file" multiple accept="image/*"/><br>
			<input type="submit" name="send_img" value="Send File" />
		</form>
		<form enctype="multipart/form-data" action="" method="POST" style="background: cadetblue;">
			<!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
			<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
			<!-- Название элемента input определяет имя в массиве $_FILES -->
			Загрузить csv в базу товаров: <input name="userfile" type="file"  /><br>
			<input type="submit" name="send_goods_csv" value="Send File" />
		</form>
		<form enctype="multipart/form-data" action="" method="POST" style="background: #ffe98c;">
			<!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
			<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
			<!-- Название элемента input определяет имя в массиве $_FILES -->
			Загрузить csv с категориями: <input name="userfile" type="file"  /><br>
			<input type="submit" name="send_cat_csv" value="Send File" />
		</form>
	</div>
	
	<div style="clear:both; white-space: nowrap;">
		Пример правильного CSV файла товаров:<br>
		id|category|name|pack|price|img|showOnMain<br>
		|;5;6;|Замок висячий AVERS PD-01-63 [6,48]|1|82,00|img/no_photo.png|1<br>
		|;1;3;|4-х нитка х/б "Стандарт" белые (оверлок машинный)|250|8,20;7,80;7,30|img/perchatki/7-1.png|1<br>
	</div>
	<br><br>
	<div style="clear:both; white-space: nowrap;">
		Пример правильного CSV файла категорий:<br>
		id|parentCat|name|priceCat|unit<br>
		|1|Перчатки "Зима" двойные|до 600 пар;от 600 до 6000 пар;свыше 6000 пар|шт<br>
		|0|Замки|Цена|шт<br>
		|5|Замки висячие|Цена|шт<br>
	</div>
	
	<a href="example.xls">Пример заполнения</a>
	
	<div class="cat_edit"><?=$cat?></div>
	
</div>
</body>
</html>