<?php 
date_default_timezone_set('Europe/Moscow');
echo '<pre>';
print_r($_FILES);


if (isset($_FILES['userfile'])){
	$uploaddir = "./rozbyn/";
	if (is_array($_FILES['userfile']['name'])){
		$countFiles = count($_FILES['userfile']['name'])-1;
		for($i=0;$i<=$countFiles;$i++){
			$uploadfile = $uploaddir . basename($_FILES['userfile']['name'][$i]);
			if (move_uploaded_file($_FILES['userfile']['tmp_name'][$i], $uploadfile)) {
				echo "Файл корректен и был успешно загружен.\n";
			} else {
				echo "Файл не загружен!\n";
			}
		}
	} else {
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			echo "Файл корректен и был успешно загружен.\n";
		} else {
			echo "Файл не загружен!\n";
		}
	}
}



//print_r($_FILES);
//print_r($_SERVER);

print "</pre>";




?>

<!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
<form enctype="multipart/form-data" action="" method="POST" >
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    Отправить этот файл: <input name="userfile[]" type="file" multiple accept="image/*"/>
    <input type="submit" value="Send File" />
</form>