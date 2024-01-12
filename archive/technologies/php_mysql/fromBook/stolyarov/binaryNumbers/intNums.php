<?php
showNumAsBinary(0);
showNumAsBinary(10);
showNumAsBinary(-10);
$inv = ~ 10 + 1;
showNumAsBinary($inv);
dump(changeNumSign(-156));


















function showNumAsBinary($num) {
	$str = sprintf('%064b', $num);
	$strResult = '';
	for ($i = 0; $i < 16; $i++) {
		$beginPos = $i * 4;
		$strPart = substr($str, $beginPos, 4);
		$strResult .= $strPart . ($i === 15 ? '' : ' ');
	}
	dump($strResult);
}



function changeNumSign($num) {
	// чтобы изменить знак числа нужно инвертировать все биты и прибавить единицу
	return (~ $num) + 1;
}







































