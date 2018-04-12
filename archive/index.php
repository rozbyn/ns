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
	sort($arrOfFolders);
	sort($arrOfFiles);
	foreach($arrOfFolders as $val){
		$stringHtml .= '<div class="expl_folder"><input type="hidden" value="'.$val.'">';
		$stringHtml .= showCurrentDir($val);
		$stringHtml .= '</div>';
	}
	foreach($arrOfFiles as $val){
		$stringHtml .= '<div class="expl_file"><a href="technologies/'.$val.'" target="_blank">';
		$stringHtml .= showCurrentDir($val);
		$stringHtml .= '</a><a href="https://github.com/rozbyn/ns/blob/master/archive/technologies/'.$val.'" target="_blank" title="code on github"><img class="github_link" src="../img/gh.png"></a></div>';
	}
	$no_explDiv ? '' : $stringHtml .= '</div>';
	return $stringHtml;
}


/////////////////////////////////



$dir = 'technologies';
$cdir = scandir($dir);
$folders = [];
foreach($cdir as $key => $val){
	if ($val != '.' && $val != '..'){
		if (is_dir($dir . '/' . $val)){
			$folders[] = $val;
		}
	}
}

$content = '';

if (!empty($folders)){
	foreach($folders as $fold_path){
		$arrOfFiles = [];
		$arrOfFold = [];
		$cdir = scandir($dir.'/'.$fold_path);
		if (!empty($cdir)){
			foreach($cdir as $fold_path2){
				if ($fold_path2 != '.' && $fold_path2 != '..'){
					if (is_dir($dir.'/'.$fold_path.'/'.$fold_path2)){
						$arrOfFold[]=$fold_path.'/'.$fold_path2;
					} else {
						$arrOfFiles[]= $fold_path.'/'.$fold_path2;
					}
				}
			}
		}
		$parent_dir = '';
		$curr_folder = $fold_path;
		$content .= pageDataToHtml($parent_dir, $curr_folder, $arrOfFold, $arrOfFiles);
	}
}









?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../reset.css" type="text/css">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Archive</title>
</head>
<body>
    <div class="main">
		<?= $content ?>
	    
    </div>
</body>
<script type="text/javascript" src="script.js"></script>
</html>
