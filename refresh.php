
<?php 
if (isset($_GET['file'])){
	$file = $_GET['file'];
	if ((strrpos($file, '/master/') !== false) && (strrpos($file, 'https://raw.githubusercontent.com/rozbyn/ns') === 0)){
		$localFile = substr($file, strrpos($file, '/master/')+8);
		if (is_file($localFile)){
			$cont = file_get_contents($file);
			if($cont !== false){
				file_put_contents($localFile, $cont);
				echo 'Файл "' .$localFile. '" обновлен!<br>';
			}
			file_put_contents($localFile, $cont);
			echo 'Файл "' .$localFile. '" обновлен!<br>';
		} elseif (isset($_GET['CrNw']) && $_GET['CrNw']==='true') {
			$cont = file_get_contents($file);
			if($cont !== false){
				file_put_contents($localFile, $cont);
				echo 'Файл "' .$localFile. '" создан!<br>';
			}
		} else {
			echo 'Че хотел?(?CrNw=true)' . '<br>';
		}
	} else {
		$cont = file_get_contents($file);
		if (file_put_contents('cont_temp.txt', $cont)){
			if (!isset($_GET['n'])){
				$v = substr($file, strrpos($file, '/')+1);
				$fN = preg_replace('/[\[\]\{\}\-:;\'><—,?\/ \!@"_#$%^&()*+=|\\~`]{1}/iu', '', $v);
			} else {
				$fN = $_GET['n'];
			}
			$a = strpos($file, '//');
			$b = substr($file, $a+2);
			$c = strpos($b, '/');
			$site = substr($b, 0, $c);
			echo $site . '<br>';
			echo $fN . '<br>';
			if (!is_dir('d/'.$site)){
				mkdir('d/'.$site);
			}
			if (file_put_contents("d/$site/".$fN, $cont)){
				echo 'Файл успешно закачан!' . '<br>';
			}
		} else {
			echo 'Файл не закачан! Ошибка!' . '<br>';
		}
	}
}




?>