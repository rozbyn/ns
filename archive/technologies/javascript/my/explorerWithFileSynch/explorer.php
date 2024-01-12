<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
//define('ROOT_DIR', realpath($_SERVER['DOCUMENT_ROOT'].'/../'));
//define('ROOT_DIR', realpath(__DIR__.'/test/'));
define('ROOT_DIR', realpath(__DIR__));


if(
		$_SERVER['REQUEST_METHOD'] === 'GET' 
		&& $_REQUEST['ACTION'] === 'DOWNLOAD_FILE_CONTENT'
		&& is_file($_REQUEST['PATH'])
){
	file_force_download($_REQUEST['PATH']);
	exit;
}









if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$jsonArr = [];
//	dump2($_REQUEST);
//	dump2($_FILES);
//	dump2(ROOT_DIR);
	
	if($_REQUEST['ACTION'] === 'SAVE_FILE_CONTENT') {
//		dump2($_REQUEST);
//		dump2($_FILES);
		if(
				!is_file($_REQUEST['PATH'])
				|| !is_uploaded_file($_FILES['modifiedFile']['tmp_name'])
		){
			$jsonArr['ERROR'] = 'File not found';
			showJsonAndExit();
		}
		
		
		$newFileContent = file_get_contents($_FILES['modifiedFile']['tmp_name']);
		if($newFileContent === false){
			$jsonArr['ERROR'] = 'Error temp file reading';
			showJsonAndExit();
		}
		
		
//		$result = file_put_contents($_REQUEST['PATH'], $newFileContent, LOCK_EX);
		if($result === false){
			$jsonArr['ERROR'] = 'Error target file writing';
			showJsonAndExit();
		}
		
		
		$jsonArr['SUCCESS'] = 'Y';
		$jsonArr['WRITING_BYTES'] = $result;
		
		
	} else if ($_REQUEST['ACTION'] === 'GET_FOLDER_INFO') {
		$targetFolder = false;
		if($_REQUEST['FOLDER'] === 'ROOT_DIR'){
			$targetFolder = ROOT_DIR;
		} else if ($_REQUEST['FOLDER'] === ROOT_DIR){
			$targetFolder = ROOT_DIR;
		} else if (isChildFolder(ROOT_DIR, $_REQUEST['FOLDER'])) {
			$targetFolder = $_REQUEST['FOLDER'];
		}
		if(!$targetFolder) {
			$jsonArr['ERROR'] = 'Folder not found';
			showJsonAndExit();
		}
		
		$resultArr = [];
		if($targetFolder !== ROOT_DIR){
			$resultArr['parentFolder'] = getElementInfo($targetFolder . '/../');
		}
		
		$resultArr['currentFolder'] = getElementInfo($targetFolder);
		
		$folderElements = array_diff(scandir($targetFolder), array('..', '.'));
		foreach ($folderElements as $fElement) {
			$fElemPath = $targetFolder . '/' . $fElement;
			if(is_dir($fElemPath)){
				$resultArr['childFolders'][$fElement] = getElementInfo($fElemPath);
			} else if (is_file($fElemPath)){
				$resultArr['childFiles'][$fElement] = getElementInfo($fElemPath);
			}
		}
		$jsonArr = $resultArr;
		
		
		
		
		
//		dump2($resultArr);
		
		
		
		
		
		
		
	}
	showJsonAndExit();
	
	
	
	
} else {?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>Файлы</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="script.js"></script>
		<link href="style.css" type="text/css" rel="stylesheet">
	</head>
	<body>
		<svg version="1.1" xmlns="http://www.w3.org/2000/svg" style="display: none" >
			<symbol id="fileSynchIcon" viewBox="47 47 417 417" xml:space="preserve">
			<path d="M72,480H310.369A111.987,111.987,0,0,1,400,276.666V128H344a40.045,40.045,0,0,1-40-40V32H72A24.028,24.028,0,0,0,48,56V456A24.028,24.028,0,0,0,72,480Zm144-64H184a8,8,0,0,1,0-16h32a8,8,0,0,1,0,16Zm0-48H168a8,8,0,0,1,0-16h48a8,8,0,0,1,0,16Zm64-96H216a8,8,0,0,1,0-16h64a8,8,0,0,1,0,16Zm80-48H280a8,8,0,0,1,0-16h80a8,8,0,0,1,0,16Zm0-64a8,8,0,0,1,0,16H168a8,8,0,0,1,0-16ZM88,112h96a8,8,0,0,1,0,16H88a8,8,0,0,1,0-16Zm0,48h48a8,8,0,0,1,0,16H88a8,8,0,0,1,0-16Zm0,48H248a8,8,0,0,1,0,16H88a8,8,0,0,1,0-16Zm0,48h96a8,8,0,0,1,0,16H88a8,8,0,0,1,0-16Zm0,48H232a8,8,0,0,1,0,16H88a8,8,0,0,1,0-16Zm0,48h48a8,8,0,0,1,0,16H88a8,8,0,0,1,0-16Zm0,48h64a8,8,0,0,1,0,16H88a8,8,0,0,1,0-16ZM320,88V43.313L388.687,112H344A24.027,24.027,0,0,1,320,88Zm48,200a96,96,0,1,0,96,96A96.108,96.108,0,0,0,368,288Zm63.226,131.433a64,64,0,0,1-118.261-6.375l-4.92,7.38a8,8,0,0,1-13.312-8.876l16-24a8,8,0,0,1,11.094-2.218l24,16a8,8,0,0,1-8.875,13.312l-8.428-5.618a48,48,0,0,0,88.25,3.529,8,8,0,0,1,14.452,6.866Zm-5.959-39a8,8,0,0,1-11.094,2.218l-24-16a8,8,0,0,1,8.875-13.312l8.428,5.618a48,48,0,0,0-88.25-3.529,8,8,0,0,1-14.452-6.866,64,64,0,0,1,118.261,6.375l4.92-7.38a8,8,0,0,1,13.312,8.876Z"/>
			</symbol>
		</svg>
		
		<div id="preloader" style="background-color: #fff;">
			<svg version="1.1" width="228px" height="228px" viewBox="0 0 128 128" xml:space="preserve" id="preloader_image">
				<g>
					<path d="M78.75 16.18V1.56a64.1 64.1 0 0 1 47.7 47.7H111.8a49.98 49.98 0 0 0-33.07-33.08zM16.43 49.25H1.8a64.1 64.1 0 0 1 47.7-47.7V16.2a49.98 49.98 0 0 0-33.07 33.07zm33.07 62.32v14.62A64.1 64.1 0 0 1 1.8 78.5h14.63a49.98 49.98 0 0 0 33.07 33.07zm62.32-33.07h14.62a64.1 64.1 0 0 1-47.7 47.7v-14.63a49.98 49.98 0 0 0 33.08-33.07z" fill="#545c6a" fill-opacity="1"/>
					<animateTransform attributeName="transform" type="rotate" from="-90 64 64" to="0 64 64" dur="0.5" repeatCount="indefinite"></animateTransform>
				</g>
			</svg>
			<div id="preloader_text"></div>
		</div>
		<div id="main">
			<div id="explorer_container"></div>
		</div>
		<!--<input id="debugFile" type="file">-->
		<div id="synchFilePopupOverlay" class="popupContainerOverlay">
			<div class="filePopupCont">
				<div class="popupHeader">
					<div class="popupHeaderText">Синхронизация файла <span id="headerFileName">script.js</span></div>
					<div id="closePopupBtn" class="popupHeaderCloseIcon">&#10799;</div>
				</div>
				<div class="popupBody">
					<div class="infoMess">
						Начать синхронизацию файла на сервере с локальной копией.
					</div>
					<div class="infoMess">
						Файл: <span id="serverFileName">script.js</span>
					</div>
					<div class="infoMess">
						Полный путь на сервере: 
						<a download id="serverFilePathLink"></a>
					</div>
					<div class="infoMess">
						Для начала синхронизации выберите файл на вашем компьютере, который будет синхронизироваться с выбранным файлом на сервере.
					</div>
					<div id="dropFileArea" class="chooseLocalFileArea">
						<form id="localFileInputForm"><input id="localFileInput" type="file"></form>
						<div id="dropFileHereText">
							Перетащите сюда файл
						</div>
					</div>
					
				</div>
				
			</div>
		</div>
		<div id="activeSynchWindow">
			<div class="activeSynchHeader">
				<div class="activeSynchHeaderText">Синхронизация файлов</div>
				<div id="activeSynchMinimizeIcon" class="activeSynchMinimizeIcon upIcon"></div>
			</div>
			<table class="activeSynchItemsTable">
<!--				<thead>
					<tr>
						<th>Файл</th>
						<th>Обновления</th>
						<th>Статус</th>
						<th>Отмена</th>
					</tr>
				</thead>-->
				<tbody id="activeSynchItemsTbody">
<!--					
					<tr>
						<td>script.js</td>
						<td><div class="loadingStatusIndicator"></div></td>
						<td>13</td>
						<td><div class="stopSynchIcon">&#10799;</div></td>
					</tr>
					<tr>
						<td>script.js</td>
						<td><div class="loadingStatusIndicator"></div></td>
						<td>13</td>
						<td><div class="stopSynchIcon">&#10799;</div></td>
					</tr>
					<tr>
						<td>script.js</td>
						<td><div class="loadingStatusIndicator"></div></td>
						<td>13</td>
						<td><div class="stopSynchIcon">&#10799;</div></td>
					</tr>
					<tr>
						<td>script.js</td>
						<td><div class="loadingStatusIndicator"></div></td>
						<td>13</td>
						<td><div class="stopSynchIcon">&#10799;</div></td>
					</tr>
					-->
				</tbody>
			</table>
		</div>
		
	</body>
</html>





	
	
	
	
<?php }


function showJsonAndExit() {
	global $jsonArr;
	header('Content-Type: application/json');
	echo json_encode($jsonArr);
	exit;
}



function isChildFolder($parentFolder, $childFolder) {
	if(!is_dir($parentFolder) || !is_dir($childFolder)) return false;
	$parentFolder = realpath($parentFolder);
	$childFolder = realpath($childFolder);
	$pos = strpos($childFolder, $parentFolder);
	return $pos === 0;
}

function getElementInfo($path) {
	$realPath = realpath($path);
	$res = ['path'=>$realPath, 'name'=> basename($realPath)];
	if(is_file($realPath)){
		$tmpHref = getFileHref($realPath);
		if($tmpHref) $res['href'] = $tmpHref;
	}
	
	return $res;
}

function getFileHref($filePath, $relative = false) {
	$docRoot = $_SERVER['DOCUMENT_ROOT'];
	$filePath = realpath($filePath);
	if(!$filePath) return false;
	if(strpos($filePath, $docRoot) !== 0) return false;
	$relHref = substr($filePath, strlen($docRoot));
	if($relative) return $relHref;
	$host = 'http'.($_SERVER['SERVER_PORT'] == 443 ? 's' : '').'://'.$_SERVER['SERVER_NAME'];
	return $host . $relHref;
}

function file_force_download($file) {
	if (file_exists($file)) {
		// сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
		// если этого не сделать файл будет читаться в память полностью!
		if (ob_get_level()) {
			ob_end_clean();
		}
		
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		// заставляем браузер показать окно сохранения файла
		header('Content-Description: File Transfer');
		header('Content-Type: '.$finfo->file($file));
		header('Content-Disposition: attachment; filename=' . basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		// читаем файл и отправляем его пользователю
		readfile($file);
		exit;
	}
}
