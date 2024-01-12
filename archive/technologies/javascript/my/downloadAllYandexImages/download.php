<?php


if($_SERVER['REQUEST_METHOD'] !== 'POST'){
//	goto showHtml;
}

if(!filter_var($_POST['LINK'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)){
//	echo 'Неверная ссылка<br>';
//	goto showHtml;
}

//$yandexContent = file_get_contents($_POST['LINK']);
$yandexContent = file_get_contents('AnswerExample.html');

//echo $yandexContent;
//exit;
echo '<pre>';

$domDocument = DOMDocument::loadHTML($yandexContent);
$xpath = new DOMXpath($domDocument);
//$elements = $xpath->query(".//*[@class='serp-item']");
$elements = $xpath->query("//div[@class][@role][@data-bem]");
$arUrls = [];
foreach ($elements as $entry) {
   
//	 var_dump($entry);
//	 var_dump($entry->getAttribute('class'));
//	 var_dump($entry->getAttribute('data-bem'));
	 $itemParams = @json_decode($entry->getAttribute('data-bem'), true);
	 if(
			 is_array($itemParams) 
			 && !empty($itemParams['serp-item']['img_href'])
			 && filter_var($itemParams['serp-item']['img_href'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)
		){
		 
		 $arUrls[] = $itemParams['serp-item']['img_href'];
	 }
   
}

if(empty($arUrls)){
	goto showHtml;
}

require_once '../../../php_mysql/my/getContentsAsync/getContentsAsynch.php';

$results = getContentsAsync($arUrls);
foreach ($results as $url => $downloadResult) {
	unset($downloadResult['content']);
	var_dump($downloadResult);
}




//var_dump($results);
//var_dump($_POST);
//var_dump(htmlspecialchars($yandexContent));
//var_dump($elements);
echo '</pre>';


showHtml:
?>

<form action="download.php" method="POST">
	<table>
		<tbody>
			<tr>
        <td>Ссылка на страницу поиска по картинке Яндекса</td>
        <td><input name="LINK"></td>
			</tr>
		</tbody>
	</table>
	<input type="submit">
</form>