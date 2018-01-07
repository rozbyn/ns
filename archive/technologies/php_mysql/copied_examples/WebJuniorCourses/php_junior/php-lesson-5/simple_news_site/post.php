<?php

	if(!isset($_GET['id'])){
		echo 'Ошибка 404, не передано название';
	}	
	elseif(!file_exists('data/' . $_GET['id'])){
		echo 'Ошибка 404. Нет такой статьи!';
	}
	else{
		$content = file_get_contents('data/' . $_GET['id']);

		echo nl2br($content);
	}