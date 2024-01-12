<?php



/*
			 // https://www.youtube.com/watch?v=e7Wukn56-O4
			 // https://www.youtube.com/watch?v=8afbTaA-gOQ
       Числа с плавающей точкой
			 S - бит знака (+/-)
			 B - основание (2)
			 E - порядок (степень двойки + 127)
			 M - мантисса (значащие цифры)

			 Формула в общем виде
			 ((-1) ^ S) * M * (B ^ E)
 
			 Формула для двоичной системы
			 ((-1) ^ S) * M * (2 ^ E)
 

			+-------------------------------------------------------------------+
			|S| |   Порядок(8)  | |               Мантисса(23)                  |
			+-------------------------------------------------------------------+
			|0| |1|0|0|0|0|0|0|1| |0|1|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|
			+-------------------------------------------------------------------+
			|0| |1|0|0|0|0|0|0|1| |0|1|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|
			+-------------------------------------------------------------------+
			


 */



//dump(getMantisseOrderAndSignFromBinFloat(convertDecFloatToBin(189.23)));
//dump(getMantisseOrderAndSignFromBinFloat(convertDecFloatToBin(10.5)));
//dump(getMantisseOrderAndSignFromBinFloat(convertDecFloatToBin(-15)));

$nums = [
	0,
	1,
	-1,
	1.5,
	-1.5,
	-1.75,
	-0.03125,
	-0.3125,
	0.67,
	10.67,
	10,
	-23,
	7.152587890625,
	71.152587890625,
	711.152587890625,
	7.3814697265625,
	-3814697265625,
	7.19073486328125,
	-19073486328125,
	-0.19073486328125,
	
	
];

?>
<style>
	body{
		font-family: monospace;
	}
	table {
    border: 3px double #000;
    border-spacing: 3px;
	}
	td, th{
		border: 1px solid #000;
		padding: 5px;
	}
</style>
<table>
	<thead>
    <tr>
			<th>Число</th>
			<th>Бинарная строка в IEEE754</th>
			<th>Число из бинарной строки IEEE754</th>
			<th>Изначачальное и полученное число равны?</th>
    </tr>
	</thead>
	<tbody>
	<?php foreach ($nums as $num) : ?>
		<tr>
		<?php
		$IEEE754_binStr = convertDoubleToIEEE754($num);
		$resultDecNumber = convertIEEE754toDouble($IEEE754_binStr);
		$resultMatch = $num === $resultDecNumber ? 'true' : 'false';
		?>
			<td><?=$num?></td>
			<td><?=$IEEE754_binStr?></td>
			<td><?=$resultDecNumber?></td>
			<td><?=$resultMatch?></td>
		</tr>
	<?php endforeach;
	?>
	</tbody>

</table>



<?php






//dump(convertDecFloatToBin(2.1));
//dump(convertDecFloatToBin(2.25));
//dump(convertDecFloatToBin(2.50));
//dump(convertDecFloatToBin(2.75));
//dump(convertDecFloatToBin(2.125));
//dump(convertDecFloatToBin(2.625));
//dump(convertDecFloatToBin(2.3125));
//dump(convertDecFloatToBin(2.15625));
//dump(convertDecFloatToBin(2.0625));
//
//
//
//dump(convertBinFloatToDec(convertDecFloatToBin(2.1112345)));
//dump(convertBinFloatToDec('-10.00011001100110011001100110011001100110011001'));
//dump(convertBinFloatToDec('-10.01'));
//dump(convertBinFloatToDec('10.1'));
//dump(convertBinFloatToDec('10.11'));
//dump(convertBinFloatToDec('10.001'));
//dump(convertBinFloatToDec('10.111'));
//dump(convertBinFloatToDec('10.0001'));



//$num = 5.40625;
//
//dump(convertDecFloatToBin($num), convertBinFloatToDec(convertDecFloatToBin($num)));










function convertDoubleToIEEE754($double) {
	$normalFormInfo = getMantissePowerAndSignFromBinFloat(convertDecFloatToBin($double));
	if(!$normalFormInfo) false;
	if($normalFormInfo['power'] === 'SPECIAL_CASE:ZERO'){
		return $normalFormInfo['sign'].'00000000'.'00000000000000000000000';
	}
	if($normalFormInfo['power'] > 127){
		// 'SPECIAL_CASE:INFINITE'
		return $normalFormInfo['sign'].'11111111'.$normalFormInfo['mantisse'];
	}
	if($normalFormInfo['power'] < -126){
		// 'SPECIAL_CASE:TOO_SMALL'
		return $normalFormInfo['sign'].'00000000'.$normalFormInfo['mantisse'];
	}
	$bias = ((pow(2, 8)) / 2) - 1; // 127
	// формула: (2 ^ (k - 1)) - 1, где k - количество битов, выделенных под порядок
	
	$powerWithBiasBin = convertDecFloatToBin($bias + $normalFormInfo['power']);
	if(strlen($powerWithBiasBin) < 8){
		$powerWithBiasBin = str_repeat('0', 8 - strlen($powerWithBiasBin)) . $powerWithBiasBin;
	}
//	else if (strlen($powerWithBiasBin) > 8) {
//		// 'SPECIAL_CASE:INFINITE'
//		return $normalFormInfo['sign'].'11111111'.$normalFormInfo['mantisse'];
//	}
	
	return $normalFormInfo['sign'] . $powerWithBiasBin . $normalFormInfo['mantisse'];
}







function convertIEEE754toDouble($IEEE754_binStr) {
	if(strlen($IEEE754_binStr) !== 32) return false;
	$sign = $IEEE754_binStr[0];
	$powerWithBiasBin = substr($IEEE754_binStr, 1, 8);
	$mantisse = substr($IEEE754_binStr, 9);
	if($powerWithBiasBin === '00000000'){
		if(strpos($mantisse, '1') === false){
			return 0;
		} else {
			return NaN;
		}
	} else if ($powerWithBiasBin === '11111111'){
		return NaN;
	}
	$bias = ((pow(2, 8)) / 2) - 1; // 127
	$powerWithBiasBinTrimmed = ltrim($powerWithBiasBin, '0');
	$powerWithBiasDec = convertBinFloatToDec($powerWithBiasBinTrimmed);
	$power = $powerWithBiasDec - $bias;
	$normalFormInfo = [
		'sign' => $sign,
		'power' => $power,
		'mantisse' => $mantisse,
	];
	$binFloat = getBinFloatFromMantissePowerAndSign($normalFormInfo);
	return convertBinFloatToDec($binFloat);
}


function convertDecFloatToBin($float) {
	// https://stackoverflow.com/questions/3954498/how-to-convert-float-number-to-binary
	$sign = '';
	if(strpos($float, '-') === 0){
		$sign = '-';
		$float = substr($float, 1);
	}
	$dotPos = strpos((string)$float, '.');
	if($dotPos === false)	{
		return $sign . decbin($float);
	}
	$intPart = substr($float, 0, $dotPos);
	$intPartBin = decbin($intPart);
	$fractionPart = substr($float, $dotPos+1);
	$fractionPartBin = convertDecFractionalPartToBin($fractionPart);
//	dump($intPartBin, $fractionPartBin);
	return $sign . ($intPartBin . '.' . $fractionPartBin);
}




function convertDecFractionalPartToBin($fractionPart, $maxLen = 64) {
	$fractionPartBin = '';
	$fractionPartWithZero = (float) ('0.'.$fractionPart);
	$k = 0;
	while (true && $k < $maxLen) {
		$mult2 = $fractionPartWithZero * 2;
//		dump($mult2);
		$dotPos = strpos((string)$mult2, '.');
		if($dotPos === false){
			$fractionPartBin .= $mult2;
			break;
		} 
		$mult2intPart = substr($mult2, 0, $dotPos);
		$mult2fractionPart = substr($mult2, $dotPos+1);
//		dump($mult2intPart, $mult2fractionPart);
		$fractionPartBin .= $mult2intPart;
		if($mult2fractionPart === '0') break;
		$fractionPartWithZero = (float) ('0.'.$mult2fractionPart);
//		dump($fractionPartWithZero);
		$k++;
	}
	
//	dump($fractionPartBin);
	return $fractionPartBin;
}




function convertBinFloatToDec($binFloat) {
	$mult = 1;
	if(strpos($binFloat, '-') === 0){
		$mult = -1;
		$binFloat = substr($binFloat, 1);
	}
	$dotPos = strpos((string)$binFloat, '.');
	if($dotPos === false)	{
		return $mult * bindec($binFloat);
	}
	$intPart = substr($binFloat, 0, $dotPos);
	$intPartDec = bindec($intPart);
	$fractionPart = substr($binFloat, $dotPos+1);
	$fractionPartDec = bindec($fractionPart) / pow(2, strlen($fractionPart));
	return $mult * ($intPartDec + $fractionPartDec);
}




function getMantissePowerAndSignFromBinFloat($binFloat) {
	$sign = 0;
	if(strpos($binFloat, '-') === 0){
		$sign = 1;
		$binFloat = substr($binFloat, 1);
	}
	if($binFloat === '0'){
		return [
			'sign' => $sign,
			'power' => 'SPECIAL_CASE:ZERO',
			'mantisse' => str_repeat('0', 23),
		];
	}
	$powerOfTwo = 0;
	$dotPos = strpos((string)$binFloat, '.');
	$onePos = strpos((string)$binFloat, '1');
	if($onePos === false){
		return false;
	}
	if($dotPos === false) {
		$powerOfTwo = strlen($binFloat) - 1;
		$normBinFloat = '1.'.substr($binFloat, 1);
	} else {
		$shift = $dotPos - $onePos;
		if($shift > 0) $shift--;
		$powerOfTwo = $shift;
		
		if((strlen($binFloat) - 1) === $onePos){
			$normBinFloat = '1.0';
		} else {
			$normBinFloat = '1.' . str_replace('.', '', substr($binFloat, $onePos+1));
		}
	}
	
	$totalMaxLength = 23 + 1 + 1; // единица спереди и точка
	$currLen = strlen($normBinFloat);
	if($currLen > $totalMaxLength){
		$normBinFloat = substr($normBinFloat, 0, $totalMaxLength);
	} else if ($currLen < $totalMaxLength){
		$normBinFloat .= str_repeat('0', $totalMaxLength - $currLen);
	}
	return [
		'sign' => $sign,
		'power' => $powerOfTwo,
		'mantisse' => substr($normBinFloat, 2)
	];
}




function getBinFloatFromMantissePowerAndSign($normalFormInfo) {
	if(
			!is_array($normalFormInfo) 
			|| !isset($normalFormInfo['sign']) 
			|| !isset($normalFormInfo['power']) 
			|| !isset($normalFormInfo['mantisse'])
	) return false;
	if($normalFormInfo['power'] === 'SPECIAL_CASE:ZERO'){
		return '0';
	}
	$sign = $normalFormInfo['sign'] === '1' ? '-' : '';
	if($normalFormInfo['power'] > 23){
		$normalFormInfo['mantisse'] .= str_repeat('0', $normalFormInfo['power'] - 23);
	}
	if($normalFormInfo['power'] > 0){
		$beforeDot = substr($normalFormInfo['mantisse'], 0, $normalFormInfo['power']);
		$afterDot = substr($normalFormInfo['mantisse'], $normalFormInfo['power']);
		$normBinFloat = '1' . $beforeDot . (strlen($afterDot) ? '.' . $afterDot : '');
		return $sign . $normBinFloat;
	} else if ($normalFormInfo['power'] < 0){
		$leadZeros = (-$normalFormInfo['power']) - 1;
		$normBinFloat = '0' . '.' . str_repeat('0', $leadZeros).'1'.$normalFormInfo['mantisse'];
		return $sign . rtrim($normBinFloat, '0');
	} else {
		return $sign . '1.' . rtrim($normalFormInfo['mantisse'], '0');
	}
}








function isDecimalFloatCanBeCastToBinaryFloatWithoutPeriodicFraction($decFloat) {
	/*
	 чтобы двоичное число после запятой было без периода, нужно проверить:
	  - отбросив целую часть получаем некое число
	  - это число должно без остатка делится на степень пятёрки
	  - степень пятёрки равна количеству цифр в числе
	  
		Например: дробное десятичное число 5,40625. Отбросив целую часть получаем 40625, в этом числе 5 цифр,
	  значит число должно нацело делится на 5 в степени 5 то есть 3125, в данном случае 40625 / 3125 = 13,
	  это означает, что число 5,40625 может быть представленно в виде двоичной дроби без периода
	 */
	$decFloat = (string)$decFloat;
	$dotPos = strpos((string)$decFloat, '.');
	if($dotPos === false) return true;
	$fractionalPart = substr($decFloat, $dotPos+1);
	$fivePow = pow(5, strlen($fractionalPart));
	return $fractionalPart % $fivePow === 0;
}


































function dump(...$vars) {
	echo "<pre>\r\n";
	foreach ($vars as $var) {
		var_dump($var);
	}
	echo "</pre>\r\n";
}