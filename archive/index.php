<?php
function generateHtml ($varables, $folders, $files, $no_explDiv = false) {
	$stringHtml = '';
	$no_explDiv ? $stringHtml = '<div class="expl_head"><div class="par_folder">' : $stringHtml = '<div class="expl_div"><div class="expl_head"><div class="par_folder">';
	$stringHtml .= '<input type="hidden" value="'.$varables['parent_path'].'">';
	$stringHtml .= $varables['parent_name'];
	$stringHtml .= '</div><div class="curr_folder">';
	$stringHtml .= '<input type="hidden" value="'.$varables['current_path'].'">';
	$stringHtml .= $varables['current_name'];
	$stringHtml .= '</div></div>';
	sort($folders);
	sort($files);
	foreach($folders as $val){
		$stringHtml .= '<div class="expl_folder"><input type="hidden" value="'.$val.'">';
		$stringHtml .= basename($val);
		$stringHtml .= '</div>';
	}
	foreach($files as $val){
		$stringHtml .= '<div class="expl_file"><a href="'.($val).'" target="_blank">';
		$stringHtml .= basename($val);
		$stringHtml .= '</a>';
		if (NEED_GITHUB_LINK) {
			$stringHtml .= '<a class="github_link" href="'.GITHUB_LINK_PREFIX.$val.'" target="_blank" title="code on github"><img class="github_img" src="../img/gh.png"></a>';
		}
		$stringHtml .= '</div>';
	}
	$no_explDiv ? '' : $stringHtml .= '</div>';
	if (function_exists('tidy_repair_string')) {
		$tidyParams = [
			'indent' => TRUE,
			'wrap' => 200,
			'show-body-only'=>1
		];
		return tidy_repair_string($stringHtml, $tidyParams);
	}
	return $stringHtml;
}
function getFiles_Folders ($path) {
	$folders = [];
	$files = [];
	$cdir = scandir($path);
	foreach ($cdir as $elem) {
		if ($elem != '.' && $elem != '..') {
			if (is_dir($y = $path . DIRECTORY_SEPARATOR . $elem)) {
				$folders[] = $y;
			} elseif (is_file($y = $path . DIRECTORY_SEPARATOR . $elem)) {
				$files[] = $y;
			}
		}
	}
	return [$folders, $files];
	
}
function realName ($path) {
	return basename(realpath($path));
}
/*-----------------------------------------------------------------------------------*/
setlocale(LC_ALL, 'ru_RU', 'RU', 'rus');
date_default_timezone_set('Europe/Moscow');
/* ---- --- -- - */
define('EXPLORE_DIR', 'technologies');
define('NEED_GITHUB_LINK', true);
define('GITHUB_LINK_PREFIX', 'https://github.com/rozbyn/ns/blob/master/archive/');
define('REAL_EXPLORE_DIR_PATH', realpath(EXPLORE_DIR));
define('REAL_EXPLORE_DIR_NAME', realName(EXPLORE_DIR));

if (isset($_POST['path'])) {
	$path = $_POST['path'];
	$realPath = realpath($path);
	if (is_dir($realPath)) {
		list($folders, $files) = getFiles_Folders($path);
		if ($path === EXPLORE_DIR) {
			$params['parent_path'] = '';
			$params['parent_name'] = '';
			$params['current_path'] = EXPLORE_DIR;
			$params['current_name'] = REAL_EXPLORE_DIR_NAME;
			exit(generateHtml ($params, $folders, $files, true));
		}
		if (($parent_path = dirname($path)) === EXPLORE_DIR) {
			$params['parent_name'] = REAL_EXPLORE_DIR_NAME;
		} else {
			$params['parent_name'] = basename($parent_path);
		}
		$params['parent_path'] = $parent_path;
		$params['current_path'] = $path;
		$params['current_name'] = basename($path);
		exit(generateHtml ($params, $folders, $files, true));
	} else {
		$params['parent_path'] = EXPLORE_DIR;
		$params['parent_name'] = 'Error, no such folder: '.$path;
		$params['current_path'] = '';
		$params['current_name'] = '';
		exit(generateHtml ($params, [], [], true));
	}
} else {
	if (is_dir(REAL_EXPLORE_DIR_PATH)) {
		list($folders, $files) = getFiles_Folders(EXPLORE_DIR);
		$params['parent_path'] = '';
		$params['parent_name'] = '';
		$params['current_path'] = EXPLORE_DIR;
		$params['current_name'] = REAL_EXPLORE_DIR_NAME;
		$content = generateHtml ($params, $folders, $files);
	} else {
		echo 'WRONG DIR: ' . EXPLORE_DIR;
	}
/* ________________________________________________________________________ */
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <style>
		body{
			overflow-y: scroll;
			font-family: sans-serif;
		}
		.main{
			background: #fff;
			max-width: 1144px;
			margin: 0  auto;
			word-wrap: break-word;
		}
		.expl_div{
			width: 530px;
			background: #ffffff;
			border: 3px solid black;
			text-align: center;
			font-size: 25px;
			margin: 18px auto;
			cursor: default;
		}
		.expl_head{
			min-height: 50px;
			padding-bottom: 5px;
		}
		.curr_folder{
			font-size: 40px;
		}
		.par_folder{
		}
		.expl_folder, .expl_file{
			min-height: 35px;
			border: 1px solid black;
			font-weight: 300;
			position: relative;
		}
		.expl_folder{
			background: #FFFF99;
		}
		.expl_file {
			 background: #FFCC99;
		}
		.expl_file>a {
			text-decoration: none;
			color: black;
			cursor: default;
			display: block;
			position: relative;
			min-height: 35px;
		}
		.expl_file:hover, .expl_folder:hover, .curr_folder:hover, .par_folder:hover {
			background: #a3a3a3;
		}
		.expl_file>a.github_link{
			min-height: 0;
		}
		.github_img {
		    position: absolute;
		    height: 35px;
		    right: 0;
		    bottom: 0;
		    cursor: pointer;
		}
		@media screen and (max-width : 530px){
			.expl_div{
				width: 100%;
			}
		}

    </style>
    <title>Explorer</title>
</head>
<body>
    <div class="main">
		<?= $content ?>
    </div>
	<!--<textarea id="debug" rows="20" cols="100"></textarea>-->
	<script>
		
		window.onload = addEvents(document);
		
		function addEvents (node) {
			folders = node.getElementsByClassName('expl_folder');
			parentFolders = node.getElementsByClassName('par_folder');
			currFolders = node.getElementsByClassName('curr_folder');
			addEventFolders(folders);
			addEventParentFolders(parentFolders);
			addEventParentFolders(currFolders);
		}
		
		function addEventParentFolders (htmlCollect){
			len = htmlCollect.length;
			for(i = 0; i < len; i++){
				htmlCollect[i].addEventListener("click", function () {
					params = 'path=' + this.firstElementChild.value;
					ajaxPost('<?= basename(__FILE__) ?>', params, this, catchAjaxForParent);
				})
			}
		}
		function catchAjaxForParent (data, node) {
			var p = node.parentNode.parentNode;
			p.innerHTML = data;
			addEvents(p);
		}
		function catchAjaxForFolders (data, node) {
			var p = node.parentNode;
			p.innerHTML = data;
			addEvents(p);
		}
		function addEventFolders(htmlCollect) {
			var len = htmlCollect.length;
			for(i = 0; i < len; i++){
				htmlCollect[i].addEventListener("click", function () {
					var params = 'path=' + this.firstElementChild.value;
					ajaxPost('<?= basename(__FILE__) ?>', params, this, catchAjaxForFolders);
				})
			}
		}
		function ajaxPost(url, params, s, callback){
			var request = new XMLHttpRequest();
			var f = callback || function(data){} ;
			request.onreadystatechange = function(){
				if (request.readyState == 4 && request.status == 200){
					//debug.value = request.responseText;
					f(request.responseText, s);
				} 
			};
			request.open('POST', url);
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			request.send(params);
		}
	</script>
</body>
</html>
<?php } ?>
