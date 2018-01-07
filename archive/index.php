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
		$stringHtml .= '</a></div>';
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
    <div class="main"><!--
        <div class="expl_div">
            <div class="expl_head">
                <div class="par_folder">
                    <p>php_mysql</p>
                </div>
                <div class="curr_folder">
                    <p>my</p>
                </div>
            </div>
            <div class="expl_folder"><p>get_include_test</p></div>
            <div class="expl_folder"><p>img</p></div>
            <div class="expl_folder"><p>mining_aggregator</p></div>
            <div class="expl_file"><p>examles_arrays.txt</p></div>
            <div class="expl_file"><p>form_of_a_word.php</p></div>
            <div class="expl_file"><p>mysql_connection_testing.php</p></div>
            <div class="expl_file"><p>show_headers_and_system_arrays.php</p></div>
            <div class="expl_file"><p>todo_my_random_generator.php</p></div>
        </div>
        <div class="expl_div">
            <div class="expl_head">
                <div class="par_folder">
                    <p>php_mysql</p>
                </div>
                <div class="curr_folder">
                    <p>my</p>
                </div>
            </div>
            <div class="expl_folder"><p>get_include_test</p></div>
            <div class="expl_folder"><p>img</p></div>
            <div class="expl_folder"><p>mining_aggregator</p></div>
            <div class="expl_file"><p>examles_arrays.txt</p></div>
            <div class="expl_file"><p>form_of_a_word.php</p></div>
            <div class="expl_file"><p>mysql_connection_testing.php</p></div>
            <div class="expl_file"><p>show_headers_and_system_arrays.php</p></div>
            <div class="expl_file"><p>todo_my_random_generator.php</p></div>
        </div>
        <div class="expl_div">
            <div class="expl_head">
                <div class="par_folder">
                    <p>php_mysql</p>
                </div>
                <div class="curr_folder">
                    <p>my</p>
                </div>
            </div>
            <div class="expl_folder"><p>get_include_test</p></div>
            <div class="expl_folder"><p>img</p></div>
            <div class="expl_folder"><p>mining_aggregator</p></div>
            <div class="expl_file"><p>examles_arrays.txt</p></div>
            <div class="expl_file"><p>form_of_a_word.php</p></div>
            <div class="expl_file"><p>mysql_connection_testing.php</p></div>
            <div class="expl_file"><p>show_headers_and_system_arrays.php</p></div>
            <div class="expl_file"><p>todo_my_random_generator.php</p></div>
        </div>
        <div class="expl_div">
            <div class="expl_head">
                <div class="par_folder">
                    <p>php_mysql</p>
                </div>
                <div class="curr_folder">
                    <p>my</p>
                </div>
            </div>
            <div class="expl_folder"><p>get_include_test</p></div>
            <div class="expl_folder"><p>img</p></div>
            <div class="expl_folder"><p>mining_aggregator</p></div>
            <div class="expl_file"><p>examles_arrays.txt</p></div>
            <div class="expl_file"><p>form_of_a_word.php</p></div>
            <div class="expl_file"><p>mysql_connection_testing.php</p></div>
            <div class="expl_file"><p>show_headers_and_system_arrays.php</p></div>
            <div class="expl_file"><p>todo_my_random_generator.php</p></div>
        </div>
        <div class="expl_div">
            <div class="expl_head">
                <div class="par_folder">
                    <p>simple_site_with_registration_authorization_and_include_text_files</p>
                </div>
                <div class="curr_folder">
                    <p>my</p>
                </div>
            </div>
            <div class="expl_folder"><p>get_include_test</p></div>
            <div class="expl_folder"><p>simple_site_with_registration_authorization_and_include_text_files</p></div>
            <div class="expl_folder"><p>mining_aggregator</p></div>
            <div class="expl_file"><p>examles_arrays.txt</p></div>
            <div class="expl_file"><p>comparison_of_two_random_numbers.php</p></div>
            <div class="expl_file"><p>mysql_connection_testing.php</p></div>
            <div class="expl_file"><p>OOP_examples_plus_function_for_HTML.php</p></div>
            <div class="expl_file"><p>GAME_choose_greater_positive_number_or_pass.php</p></div>
        </div>
        <div class="expl_div">
            <div class="expl_head">
                <div class="par_folder">
                    <p>php_mysql</p>
                </div>
                <div class="curr_folder">
                    <p>simple_site_with_registration_authorization_and_include_text_files</p>
                </div>
            </div>
            <div class="expl_folder"><p>get_include_test</p></div>
            <div class="expl_folder"><p>img</p></div>
            <div class="expl_folder"><p>mining_aggregator</p></div>
            <div class="expl_file"><p>examles_arrays.txt</p></div>
            <div class="expl_file"><p>form_of_a_word.php</p></div>
            <div class="expl_file"><p>mysql_connection_testing.php</p></div>
            <div class="expl_file"><p>show_headers_and_system_arrays.php</p></div>
            <div class="expl_file"><p>todo_my_random_generator.php</p></div>
        </div>-->
		<?= $content ?>
	    <a href="https://github.com/rozbyn/ns">Github</a>
    </div>
</body>
<script type="text/javascript" src="script.js"></script>
</html>
