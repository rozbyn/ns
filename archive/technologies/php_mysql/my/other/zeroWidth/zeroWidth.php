<?php
$a1 = '​'; //Zero Width Space &#8203;
$a2 = '‌'; // Zero Width Non-Joiner &#8204;
$a3 = '‍'; // Zero Width Joiner &#8205;
$a4 = '﻿'; // Zero Width No-Break Space &#65279;
$a5 = '‮'; // Right-To-Left Override &#8238;
$a6 = '‭'; // Left-To-Right Override &#8237;



if (isset($_POST['encodeText']) && $_POST['encodeText'] === 'true') {
	if (
		!empty($_POST['textToHide']) && 
		!empty($_POST['textForCover']) && 
		isset($_POST['onPosition']) && is_numeric($_POST['onPosition'])
	) {
		$answer = hideText($_POST['textToHide'], $_POST['textForCover'], (int)$_POST['onPosition']);
	} else {
		$answer = $_POST['textForCover'];
	}
	
	die($answer);
}

if (
	isset($_POST['decodeText']) && 
	$_POST['decodeText'] === 'true' &&
	isset($_POST['unhideText'])
) {
	$answer = unHideText($_POST['unhideText']);
	die($answer);
}



function hideText($hidingText, $coverText, $pos = 0){
	$zeroWidthHiddingText = '';
	$strLen = strlen($hidingText);
	for ($i = 0; $i < $strLen; $i++) {
		$zeroWidthHiddingText .= str_replace([1, 0], ['​', '‌'], decbin(ord($hidingText[$i])));
		$zeroWidthHiddingText .= ($strLen === $i+1)?''/*Empty*/:'‍'/*Zero Width Joiner*/;
	}
	$firstPart = mb_substr($coverText, 0, $pos, 'UTF-8');
	$secondPart = mb_substr($coverText, $pos, null, 'UTF-8');
	$return = substr_replace($coverText, $zeroWidthHiddingText, $pos, 0);
	
	
	$return = $firstPart . '﻿﻿﻿﻿' . $zeroWidthHiddingText . '﻿﻿' . $secondPart;
	
	return $return;
}

function unHideText($hiddenText){
	$unHiddenText = '';
	preg_match_all('/(?<=﻿﻿﻿)[​,‌,‍]+(?=﻿﻿)/', $hiddenText, $matches, PREG_SET_ORDER);
	
	foreach ($matches as $m) {
		$exp = explode('2', str_replace(['​', '‌', '‍'], [1, 0, 2], $m[0]));
		foreach ($exp as $binChar) {
			$unHiddenText .= chr(bindec($binChar));
		}
	}
	return $unHiddenText;
}

?>
<!DOCTYPE html> 
<html>
    <head>
        <title>Hide Text</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="styles.css" type="text/css">
		<style>
			
		</style>
    </head>
    <body>
        <div class="wrapper">
        	<div class="hideText">
				<label >Спрятать текст
					<input type="text" id="hiddenText">
				</label>
				<label >в тексте
					<textarea id="coverText"></textarea>
				</label>
				<label >на позиции
					<input type="number" min="0" id="onPos" value="1">
				</label>
				<button id="hide">Спрятать</button>
				<textarea id="textWithHidden" rows="6" cols="25" readonly placeholder="Тут будет текст со скрытым в нём текстом"></textarea>
			</div>
			<div class="unHideText">
				<label> Раскрыть в тексте
					<textarea name="" id="unhideText" rows="6" cols="25"  placeholder="Вставте сюда текст в котором хотите найти спрятанный текст"></textarea>
				</label>
				<button id="unhide">Раскрыть</button>
				
				<label>
					<textarea id="unHiddenText"  rows="2" cols="25" readonly placeholder="Спрятаный текст"></textarea>
				</label>
			</div>
        </div>
		<div id="debug"></div>
		
	<script type="text/javascript" src="script.js"></script>
    </body>
</html>