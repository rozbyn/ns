<?php
date_default_timezone_set('Europe/Moscow');
//header('Content-Type: text/html; charset=utf-8');

function showParentPath($path){
	return substr($path, 0, strrpos($path, '/'));
}
function showParrentDir($path){
	$o = showParentPath($path);
	$f = strrpos($o, '/');
	if($f == false){
		$par_folder = substr($o, $f);
	} else {
		$par_folder = substr($o, $f+1);
	}
	return $par_folder;
}
function showCurrentDir($path){
	$slashPos = strrpos($path, '/');
	if ($slashPos == 0){
		$current_folder = substr($path, $slashPos);
	} else {
		$current_folder = substr($path, $slashPos+1);
	}
	return $current_folder;
}
function pageDataToHtml($parent_path, $current_dir, $arrOfFolders, $arrOfFiles, $no_explDiv = false){
	$par_dir = showParrentDir($parent_path);
	$parent_path = showParentPath($parent_path);
	$stringHtml = '';
	$no_explDiv ? $stringHtml = '<div class="expl_head"><div class="par_folder">' : $stringHtml = '<div class="expl_div"><div class="expl_head"><div class="par_folder">';
	$stringHtml .= '<input type="hidden" value="'.$parent_path.'">';
	$stringHtml .= $par_dir;
	$stringHtml .= '</div><div class="curr_folder">';
	$stringHtml .= $current_dir;
	$stringHtml .= '</div></div>';
	sort($arrOfFolders, SORT_FLAG_CASE|SORT_NATURAL);
	sort($arrOfFiles);
	foreach($arrOfFolders as $val){
		$stringHtml .= '<div class="expl_folder"><input type="hidden" value="'.$val.'">';
		$stringHtml .= showCurrentDir($val);
		$stringHtml .= '</div>';
	}
	foreach($arrOfFiles as $val){
		$stringHtml .= '<div class="expl_file"><a href="technologies/'.$val.'"target="_blank">';
		$stringHtml .= showCurrentDir($val);
		$stringHtml .= '</a><a href="https://github.com/rozbyn/ns/blob/master/archive/technologies/'.$val.'" target="_blank" title="code on github"><img class="github_link" src="../img/gh.png"></div>';
	}
	$no_explDiv ? '' : $stringHtml .= '</div>';
	return $stringHtml;
}


/////////////////////////////////
if (isset($_POST['path'])){
	$arrOfFolders = [];
	$arrOfFiles = [];
	$path = 'technologies/'.$_POST['path'];
	if (is_dir($path)){
		$cdir = scandir($path);
		foreach($cdir as $val){
			if ($val != '.' && $val != '..'){
				if (is_dir($path.'/'.$val)){
					$arrOfFolders[] = $_POST['path'].'/'.$val;
				} elseif (is_file($path.'/'.$val)){
					$arrOfFiles[] = $_POST['path'].'/'.$val;
				}
			}
		}
	} elseif (is_file($path)) {
		header('Content-Type: text/html; charset=utf-8');
		header('Location: '.$path);
	}
	$parent_path = $_POST['path'];
	$current_dir = showCurrentDir($_POST['path']);
	$result = pageDataToHtml($parent_path, $current_dir, $arrOfFolders, $arrOfFiles, true);
	echo $result;
}

?>