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
function make_price_table($headTable = ['#', 'name', 'count', 'something'], $arrOfData1 = [[1, 'lolol', 33, 'what?'], [2, 'lolol', 99, 'nowhere']]){
	$arrOfData = $arrOfData1;
	$table = '';
	$table .= "<table><thead><tr>\n\r";
	foreach ($headTable as $val){
		$table .=  '<td>' . $val . "</td>\n\r";
	}
	$table .=  "</tr></thead>\n\r";
	$table .=  "<tbody>\n\r";
	$countRow=1;
	foreach ($arrOfData as $key1=>$record){
		$table .=  "<tr>";
		$skipImg = true;
		if ($countRow === 1){
			$skipImg = false;
		}
		foreach($record as $key2=>$val){
			if($key2==='img'){
				if($skipImg){
					$countRow--;
					continue; 
				} else {
					if(isset($arrOfData[$key1+1]['img']) && $arrOfData[$key1+1]['img']==$val){
						$countRow++;
						if(isset($arrOfData[$key1+2]['img']) && $arrOfData[$key1+2]['img']==$val){
							$countRow++;
							if(isset($arrOfData[$key1+3]['img']) && $arrOfData[$key1+3]['img']==$val){
								$countRow++;
							}
						}
					}	
					$table .= '<td rowspan="'.$countRow.'" ><div class="tblImg" style="background-image: url(\''.$val.'\')"></div></td>';
				}
			} else {
				$table .=  '<td>' . $val . '</td>';
			}
		}
		$table .=  "</tr>\n\r";
	}
	$table .=  '</tbody>';
	$table .=  '</table>';
	return $table;
}
function make_editable_price_table($headTable, $arrOfData1){
	$arrOfData = $arrOfData1;
	$table = '';
	$table .= "<table><thead><tr>\n\r";
	foreach ($headTable as $val){
		$table .=  '<td>' . $val . "</td>\n\r";
	}
	$table .=  "</tr></thead>\n\r";
	$table .=  "<tbody>\n\r";
	foreach ($arrOfData as $key1=>$record){
		$id = substr($record['article'], strrpos($record['article'],'-')+1);
		$table .=  '<tr>';
		
		foreach($record as $key2=>$val){
			if($key2==='article'){
				$categ = substr($val, 0, strrpos($val,';')+1);
				$table .=  '<td><button form="'.$id.'" type="submit" name="subm" value="'.$id.'" style="display:none;"></button><input type="text" name="category" form="'.$id.'" value="'.$categ.'">-'.$id.'</td>';
				continue; 
			}
			if($key2==='img'){
				$table .= 	'<td ><form id="'.$id.'" action="" method="POST"></form>
							<div class="tblImg" style="background-image: url(\''.$val.'\')"></div></br>
							<input form="'.$id.'" type="text" name="img" value="'.$val.'"></br>
							<form enctype="multipart/form-data" action="" method="POST">
							<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
							<input name="load_img" type="file" accept="image/*"/>
							<button type="submit" name="send_img" value="'.$id.'" />✔</button>
							</form></td>';
				continue; 
			}
			if($key2==='name'){
				$table .=	'<td><textarea rows="6" name="name" form="'.$id.'" >' . $val . '</textarea>
							<a title="Найти картинку в Яндексе" href="https://yandex.ru/images/search?text='. $val .'" target="_blank">
							<img src="img/ico/yandex.png" >
							</a></td>';
				continue; 
			}
			if($key2==='pack'){
				$table .=  '<td><input type="text" name="pack" form="'.$id.'" value="' . $val . '"></td>';
				continue; 
			}
			if($key2==='price'){
				$table .=  '<td><input type="text" name="price" form="'.$id.'" value="' . $val . '"></td>';
				continue; 
			}
			if($key2!=='deletebtn' && $key2!=='submitbtn' && $key2!=='showOnMain'){
				$table .=  '<td><input type="text" name="price2[]" form="'.$id.'" value="' . $val . '"></td>';
				continue; 
			}
			if($key2==='showOnMain'){
				if($val=='1'){
					$chkd = 'checked=""';
				} else {
					$chkd = '';
				}
				$table .=  '<td><input type="hidden" name="showOnMain" form="'.$id.'" value="0"><input type="checkbox" name="showOnMain" form="'.$id.'" value="1" '.$chkd.'></td>';
				continue; 
			}
			$table .=  '<td>'.$val.'</td>';
		}
		$table .=  "</tr> \n\r";
	}
	$table .=  '</tbody>';
	$table .=  '</table>';
	return $table;
}








///////////////


$isAdmin = false;
$infoMessage = '';
$myDbObj = \RozbynDev\Db\Mysqli::getObj();
$myDbObj->set_charset("utf8");
$showMain = true;
$showCat = false;

//проверка на админа----------
if(isset($_POST['login']) && $_POST['login']==='1'){
	if(isset($_POST['userName']) && $_POST['userName']==='admin'){
		if(isset($_POST['userPassword']) && $_POST['userPassword']==='aa1313aa'){
			setcookie("dlJniPaZps",'Njk5HhpI4u', time()+604800);
			$isAdmin = true;
		}
	}
}
if (isset($_COOKIE['dlJniPaZps']) && $_COOKIE['dlJniPaZps']==='Njk5HhpI4u'){
	setcookie("dlJniPaZps",'Njk5HhpI4u', time()+604800);
	$isAdmin = true;
}
//проверка на админа----------

//выход из админа----------
if(isset($_GET['exit'])){
	setcookie("dlJniPaZps",'', time());
	header('Location: .');
}
//выход из админа----------


if($isAdmin){
	$user = 'Админ<br>';
	$user.= '<a href="?exit=1">Выход</a><br>';
	$user.= '<a href="download.php">download.php</a>';
} else {
	$user = '<form action="." method="POST">
	<input type="text" name="userName" style="width:50px"><br>
	<input type="password" name="userPassword" style="width:50px"> 
	<input type="submit" name="login" value="1" style="display:none">
	</form>';
}


//редактирование и удаление записей------------------------
if($isAdmin){
	if(isset($_POST['del']) && is_numeric($_POST['del'])){
		$deleteId = $_POST['del'];
		$query = "DELETE FROM shop_goods WHERE id=$deleteId";
		if($myDbObj->query($query)){
			$infoMessage = 'Товар с ID="'.$deleteId.'" успешно удален!';
		} else {
			$infoMessage = 'Ошибка удаления! ID="'.$deleteId.'"';
		}
	}
	if(isset($_POST['subm']) && is_numeric($_POST['subm'])){
		$query = "UPDATE shop_goods SET category=?, img=?, name=?, pack=?, price=?, showOnMain=? WHERE id=?";
		$stmt = $myDbObj -> prepare($query);
		$price = $_POST['price'];
		$stmt -> bind_param('sssssii', $_POST['category'], $_POST['img'], $_POST['name'], $_POST['pack'], $price, $_POST['showOnMain'], $_POST['subm']);
		if($stmt->execute()){
			$infoMessage = 'Товар "'.$_POST['name'].'" успешно отредактирован!';
		} else {
			$infoMessage = 'Ошибка!';
		}
		$stmt->close();
		header('Location: #'.$_POST['subm']);
	}
	//загрузка картинки
	if(isset($_POST['send_img']) && is_numeric($_POST['send_img'])){
		if($_FILES['load_img']['error'] !== 0 ){
			//header('Location: #'.$_POST['send_img']);
			exit('Ошибка загрузки файла');
		}
		$uploaddir = "./img/fromForm/".date('d.m.Y')."/";
		if(!is_dir($uploaddir)){
			if(mkdir($uploaddir, 0777, true)){
				echo 'Папка успешно создана' . '<br>';
			} else {
				echo 'Не удалось создать папку' . '<br>';
				exit();
			}
		}
		$extension = substr($_FILES['load_img']['name'], strrpos($_FILES['load_img']['name'],'.'));
		$uploadfile = $uploaddir . $_POST['send_img'] . $extension;
		if (move_uploaded_file($_FILES['load_img']['tmp_name'], $uploadfile)) {
			echo "Файл корректен и был успешно загружен.<br>";
			$uploadfile = substr($uploadfile, 2);
			//записываем путь к файлу в бд
			$query = "UPDATE shop_goods SET img=? WHERE id=?";
			$stmt = $myDbObj -> prepare($query);
			$stmt -> bind_param('si', $uploadfile, $_POST['send_img']);
			if($stmt->execute()){
				echo 'Картинка успешна заменена. Товар с ID="'.$_POST['send_img'].'".';
				header('Location: #'.$_POST['send_img']);
			} else {
				echo 'Ошибка записи в бд!';
			}
		} else {
			echo "Файл не загружен!<br>";
		}

	}
}

//редактирование и удаление записей------------------------


//выводим прайс одной категории---------
if (!empty($_GET['cat'])){
	if(!is_numeric($_GET['cat'])){
		header('Location: .');
		exit();
	}
	//берем заголовки из категории
	$selectedCatId = $_GET['cat'];
	$query = "SELECT parentCat, name, priceCat, unit FROM shop_categories WHERE id=?";
	$stmt = $myDbObj->prepare($query);
	$stmt->bind_param('i', $selectedCatId);
	$stmt->execute();
	$stmt->bind_result($parentCat, $name, $priceCat, $unit);
	$arr = [];
	for($i=0;$stmt->fetch();$i++){
		$arr[$i]['parentCat']= $parentCat;
		$arr[$i]['name']= $name;
		$arr[$i]['priceCat']= $priceCat;
		$arr[$i]['unit']= $unit;
	}
	$stmt->close();
	if (empty($arr)){
		header('Location: .');
		exit();
	}
	$showMain = false;
	
	$tableHead = ['№', 'Картинка', 'Наименование', '"'.$arr[0]['unit'].'" в упаковке'];
	if($isAdmin){
		$tableHead[] = $arr[0]['priceCat'];
	} else {
		$prices = explode(';', $arr[0]['priceCat']);
		foreach($prices as $val){
			$tableHead[]=$val;
		}
	}
	
	
	
	//выбираем товары нужной категории
	$query = "SELECT id, category, name, pack, price, img, showOnMain  FROM shop_goods WHERE category LIKE '%;$selectedCatId;%' ORDER BY id DESC";
	$stmt = $myDbObj->prepare($query);
	$stmt->execute();
	$stmt->bind_result($id, $category, $name, $pack, $price, $img, $showOnMain);
	$tableBody = [];
	for($i=0;$stmt->fetch();$i++){
		if($isAdmin){
			$tableBody[$i]['article'] = $category.'-'.$id;
		} else {
			$tableBody[$i]['article'] = str_replace(';', '-', trim($category, ';')) . '-'.$id;
		}
		
		$tableBody[$i]['img'] = $img;
		$tableBody[$i]['name'] = $name;
		$tableBody[$i]['pack'] = $pack;
		if($isAdmin){
			$tableBody[$i]['price']=$price;
		} else {
			$price = explode(';', $price);
			foreach($price as $val){
				$tableBody[$i][]=$val;
			}
		}
		
		if($isAdmin){
			$tableBody[$i]['showOnMain'] = $showOnMain;
		}
		if($isAdmin){
			//$tableBody[$i]['submitbtn'] = '<button form="'.$id.'" type="submit" name="subm" value="'.$id.'" >Сохранить</button><input type="hidden" form="'.$id.'" name="cat" value="'.$selectedCatId.'" >';
			//$tableBody[$i]['deletebtn'] = '<form id="delete:'.$id.'"action="" method="POST"><button form="delete:'.$id.'" type="submit" name="del" value="'.$id.'">Удалить</button></form>';
		}
	}	
	$table = '<h2>'.$arr[0]['name'].'</h2>';
	//$table .= make_table($tableHead, $tableBody);
	if($isAdmin){
		$table .= make_editable_price_table($tableHead,$tableBody);
	} else {
		$table .= make_price_table($tableHead,$tableBody);
	}
	
}
//выводим прайс одной категории---------


//выводим категории------
$query = "SELECT id, parentCat, name FROM shop_categories ORDER BY id";
$stmt = $myDbObj->prepare($query);
//$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($id, $parentCat, $name);
$mainCat = [];
$subCat = [];
if (!isset($selectedCatId)){
	$selectedCatId = false;
	$selectedParentCatId = false;
}
for($i=0;$stmt->fetch();$i++){
	if ($parentCat == 0){
		if($selectedCatId==$id){$selectedParentCatId=$id;}
		$mainCat[$i]['id']=$id;
		$mainCat[$i]['name']=$name;
		
	} else {
		if($selectedCatId==$id){$selectedParentCatId=$parentCat;}
		$subCat[$i]['id'] = $id;
		$subCat[$i]['parentCat'] = $parentCat;
		$subCat[$i]['name'] = $name;
	}
}
$stmt->close();

$categories = '<ul>';
foreach($mainCat as $mCat){
	$subcatHTML = '';
	if($mCat['id'] == $selectedParentCatId){
		$categories .= '<li class="showSubCat"><a href="?cat='.$mCat['id'].'">'.$mCat['name'].'</a>';
	} else {
		$categories .= '<li class="category"><a href="?cat='.$mCat['id'].'">'.$mCat['name'].'</a>';
	}
	foreach($subCat as $key=>$sCat){
		if($sCat['parentCat'] == $mCat['id']){
			$subcatHTML .= '<li class="sub"><a href="?cat='.$sCat['id'].'">'.$sCat['name'].'</a></li>';
			unset($subCat[$key]);
		}
	}
	if(strlen($subcatHTML) !== 0){
		$categories .= '<ul>';
		$categories .= $subcatHTML;
		$categories .= '</ul>';
	}
	$categories .= '</li>';
}
$categories .= '</ul>';
//выводим категории------




//Показываем главную----------
if ($showMain){
	$query = "SELECT id, category, name, pack, price, img FROM shop_goods WHERE showOnMain=1 ORDER BY id DESC";
	$stmt = $myDbObj->prepare($query);
	//$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->bind_result($id, $category, $name, $pack, $price, $img);
	$arr = [];
	for($i=0;$stmt->fetch();$i++){
		$arr[$i]['article'] = str_replace(';', '-', trim($category, ';')) . '-'.$id;
		
		$arr[$i]['img'] = $img;
		$arr[$i]['name'] = $name;
		$arr[$i]['pack'] = $pack;
		if (($t = strpos($price, ';')) !== false){
			$price = substr($price, 0, $t);
		}
		$arr[$i]['price'] = $price;
		
	}
	$stmt->close();
	$tableHead = ['№', 'Картинка', 'Наименование', '"Шт" в упаковке', 'Цена, руб'];
	$table = '<h2>Новинки</h2>';
	//$table .= make_table($tableHead, $arr);
	$table .= make_price_table($tableHead,$arr);

}
//Показываем главную----------
















?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <style>
		html {
			height: 100vh;
  			overflow: hidden;
		}
		#preloader {
			position: absolute;
			width: 100%;
			height: 100%;
			overflow: hidden;
			top: 0px;
			left: 0;
			background: #B38F68;
			z-index: 99999999;
		}
   </style>
   <link rel="stylesheet" href="reset.css" type="text/css"/>
   <link rel="stylesheet" href="styles.css" type="text/css"/>

   <title>Онлайн витрина "100+1 мелочь"</title>
</head>
<body>
<div id="preloader"></div>
<div class="main">
	<div class="header">
		<h1><a href='.'>100+1 Мелочь</a></h1>
		<div class="account"><?=$user ?></div>
	</div>
	<div class="wrapper">
		
		<div class="aside">
			<?=$categories ?>
			<div class="clear"></div>
		</div>
		
		<div class="content">
			<?=$infoMessage ?>
			<div class="tableDiv">

			<?=$table ?>

			</div>
		</div>
		
	</div>
	<div class="footer"></div>
</div>
</body>
</html>