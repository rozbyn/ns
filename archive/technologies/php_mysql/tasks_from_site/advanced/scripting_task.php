<style>
	* {margin:0;padding:0}
	div {
		float: left;
		margin: 5px;
		padding: 5px;
		border: 1px solid black;
	}
</style>
<div>
<?php
include('input_functions.php');




function arrt($arr){
	foreach($arr as $key => $val){
		if (is_array($val)){
			arrt($val);
		} else {
			echo $key . ':' . $val . '<br>';
		}
	}
	}
/*--------------------------------------------------*/
$nextYear = date('Y') + 1;
echo floor(abs((time() - mktime(0, 0, 0, 1, 1, $nextYear)) / 86400));
echo ' дней до НГ/////////' . '<br>';
start_form();
$k1 = inp_tOp('text', 'year2', '', 'Введите год');
$b1 = button('btn1');
echo '<br>';
echo ($k1) ? (date('L', strtotime('01.01.'.$k1)) ? 'Високосный<br>' : 'Невисокосный<br>') : 'Високосный?<br>';
endForm();

$arr = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
start_form();
$k2 = inp_tOp('text', 'date2', '', '01.12.1990');
$b2 = button('btn2');
echo  '<br>';
echo ($k2) ? $arr[date('w', strtotime($k1))] : 'День недели.';
endForm();
$monts = [1=>'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];
echo date('j') . ' '. $monts[date('n')] . ' ' . date('Y') . ' года' . ', ' . $arr[date('w')] . '<br>';
start_form();
$k3 = inp_tOp('text', 'birthday2', '', '01.12.1990');
$b3 = button('btn3');
endForm();
if (!empty($k3)){
	$tstmp = strtotime($k3);
	echo date('H:i:s d.m.Y', $tstmp) . '<br>';
	$day2 = date('j', $tstmp);
	$month2 = date('n', $tstmp);
	$diff = floor(time() / 86400) - floor(mktime(3, 0, 0, $month2, $day2) / 86400);
	if ($diff<=0){
		echo 'Осталось ' . abs($diff) . 'дней1.' . '<br>';
	} else {
		$yearNext = date('Y')+1;
		$diff = floor(mktime(3, 0, 0, $month2, $day2, $yearNext) / 86400) - floor(time() / 86400);
		echo 'Осталось ' . $diff . ' дней2.' . '<br>';
	}
} else {
	echo 'Сколько дней до дня рождения?' . '<br>';
}
$sad = mktime(3, 0, 0, 5, 3);
$das = date('t', $sad);
for ($i = $das; $i > 1; $i--){
	$ot = date('w', mktime(3, 0, 0, 5, $i)) == 0;
	if($ot){break;}
}
$currYear = time() - mktime(3, 0, 0, 5, $i);
$nextYear = time() - mktime(3, 0, 0, 5, $i, date('Y')+1);
if ($currYear<0){
	echo 'До масленицы ' . floor(abs($currYear/86400)) . ' дней' . '<br>';
} else {
	echo 'До масленицы ' . floor(abs($nextYear/86400)) . ' дней' . '<br>';
}
$s = time()%60;
$m = floor(time()/60)%60;
$h = floor(time()/3600)%24;
$d = floor(time()/86400)%365;
$mon = floor(time()/86400);
echo "$d $h $m $s" . '<br>';
echo date('z') . '<br>';
$zod = [1=>'Вы козерог', 'Вы водолей', 'Вы рыбы', 'Вы овен', 'Вы телец', 'Вы близнецы',
'Вы рак', 'Вы лев', 'Вы дева', 'Вы весы', 'Вы скорпион', 'Вы стрелец', 'Вы говноед', 'Введите дату в формате 31.12'];

function zodiacSign($str){
	$arr = explode('.', $str);
	if(count($arr) == 1 || count($arr) > 2){return 14;}
	switch ($arr[1]) {
		case 1:
			$arr[0] < 20 ? $rez = 1 : $rez = 2;
			break;
		case 2:
			$arr[0] < 19 ? $rez = 2 : $rez = 3;
			break;
		case 3:
			$arr[0] < 21 ? $rez = 3 : $rez = 4;
			break;
		case 4:
			$arr[0] < 20 ? $rez = 4 : $rez = 5;
			break;
		case 5:
			$arr[0] < 21 ? $rez = 5 : $rez = 6;
			break;
		case 6:
			$arr[0] < 21 ? $rez = 6 : $rez = 7;
			break;
		case 7:
			$arr[0] < 23 ? $rez = 7 : $rez = 8;
			break;
		case 8:
			$arr[0] < 23 ? $rez = 8 : $rez = 9;
			break;
		case 9:
			$arr[0] < 23 ? $rez = 9 : $rez = 10;
			break;
		case 10:
			$arr[0] < 23 ? $rez = 10 : $rez = 11;
			break;
		case 11:
			$arr[0] < 22 ? $rez = 11 : $rez = 12;
			break;
		case 12:
			$arr[0] < 22 ? $rez = 12 : $rez = 1;
			break;
		default: $rez = 13;
	}
	return $rez;
}


start_form();
$k3 = inp_tOp('text', 'zodiacSign', '', '01.12');
$b3 = button('btn4');
echo  '<br>';
if($k3){echo $zod[zodiacSign($k3)];}
endForm();
$arr = ['01.01' => 'Новый год', '23.02'=> 'День защитника отечества', 
'08.03'=>'Международный женский день', '12.04'=>'День космонавтики',
'01.05' => 'День труда', '09.05'=>'День победы', '01.06'=>'День защиты детей', 
'19.06' => 'День рождения', '14.09'=>'Праздник говна Сегодня'];

if  (isset($arr[date('d') . '.' . date('m')])){
	echo $arr[date('d') . '.' . date('m')] . '<br>';
}
$goroskop = [1=>['14.09'=>'Вам сегодня хорошо', '15.09' => 'Вам сегодня отлично', '16.09' => 'Вам сегодня просто супер'],
['14.09'=>'Вам сегодня норм', '15.09' => 'Вам сегодня заебись', '16.09' => 'Вам сегодня волшебно'],
['14.09'=>'Вам сегодня классно', '15.09' => 'Вам сегодня превосходно', '16.09' => 'Вам сегодня прекрасно'],
['14.09'=>'Вам сегодня восхитительно', '15.09' => 'Вам сегодня кайфово', '16.09' => 'Вам сегодня все по плечу'],
['14.09'=>'Вам сегодня чудесно', '15.09' => 'Вам сегодня восторжено', '16.09' => 'Вам сегодня здорово'],
['14.09'=>'Вам сегодня спокойно', '15.09' => 'Вам сегодня спокойно', '16.09' => 'Вам сегодня просто спокойно'],
['14.09'=>'Вам сегодня славно', '15.09' => 'Вам сегодня чудно', '16.09' => 'Вам сегодня клёво'],
['14.09'=>'Вам сегодня чувственно', '15.09' => 'Вам сегодня добротно', '16.09' => 'Вам сегодня идеально'],
['14.09'=>'Вам сегодня ништяк', '15.09' => 'Вам сегодня изумительно', '16.09' => 'Вам сегодня круто'],
['14.09'=>'Вам сегодня офигительно', '15.09' => 'Вам сегодня чудненько', '16.09' => 'Вам сегодня мощно'],
['14.09'=>'Вам сегодня сладко', '15.09' => 'Вам сегодня умиротворенно', '16.09' => 'Вам сегодня легко'],
['14.09'=>'Вам сегодня мило', '15.09' => 'Вам сегодня ясно', '16.09' => 'Вам сегодня тепло'],
];

start_form();
$k3 = inp_tOp('text', 'goroskopZodiac', '', '01.12');
$b3 = button('btn5');
echo '<br>';
$d = date('d') . '.' . date('m');
if ($k3){
	$g = zodiacSign($k3);
	if ($g != 14 && $g != 13){
		$d = mt_rand(14,16).'.09';
		echo $zod[$g] . '<br>';
		echo $goroskop[$g][$d] . '<br>';
	}
}
echo  '<br>';
endForm();
start_form();
$str = 'Кресты объединяют три группы — кардинальный (Овен, Рак, Весы, Козерог), фиксированный (Телец, Лев, Скорпион, Водолей) и мутабельный (Близнецы, Дева, Стрелец, Рыбы). Знаки в крестах отделены друг от друга на 90°.';
$separators = str_split('[]{}:;\'><,.?/!@"#$%^&*+=|\\~`', 1);
$sepReg = preg_split('/[\[\]\{\}\-:;\'><—,.?\/ \!@"_#$%^&()*+=|\\~`]{1}/iu' ,$str, -1, PREG_SPLIT_NO_EMPTY);
arrt($sepReg);

$ta = textarea('qwe', 'cols="40" rows="5"');
echo '<br>';
button('btn6');
if(!empty($ta)){
	$str = $ta;
	$strLen = mb_strlen($str);
	$wordsLen = count(preg_split('/[\[\]\{\}\-:;\'><—,.?\/ \!@"_#$%^&()*+=|\\~`]{1}/iu' ,$str, -1, PREG_SPLIT_NO_EMPTY));
	echo $wordsLen . '<br>';
	$spasebar = $strLen - substr_count($str, ' ');
	echo "В тексте $strLen символов, $wordsLen слов, символов без пробелов - $spasebar" . '<br>';
}
endForm();

function mb_count_chars($input) {
    $l = mb_strlen($input, 'UTF-8');
    $unique = array();
    for($i = 0; $i < $l; $i++) {
        $char = mb_substr($input, $i, 1, 'UTF-8');
        if(!array_key_exists($char, $unique))
            $unique[$char] = 0;
        $unique[$char]++;
    }
    return $unique;
}
start_form();
$ta = textarea('count_chars', 'cols="40" rows="5"');
echo  '<br>';
button('btn7');
echo '<br>';
if ($ta){
	$tasd = mb_count_chars($ta);
	$sum = array_sum($tasd);
	foreach($tasd as $key => $value){
		$tasd[$key] = round(($value/$sum)*100, 2) . '%';
	}
	arrt($tasd);
}
endForm();

start_form();
$arr = ['Пенал', 'Клавиатура', 'Мышка', 'Ручка', 'Тетрадь', 'Таблица', 'Синус', 'Корень'];
$k3 = inp_tOp('text', 'sumbolsInWord', '', 'несколько букв');
button('btn8');
endForm();
if($k3){
	$str = preg_split("//iu", $k3, -1, PREG_SPLIT_NO_EMPTY);
	foreach($arr as $val){
		$a = 0;
		foreach($str as $sumbl){
			if (mb_stripos($val, $sumbl) !== false){$a++;}
		}
		if($a == count($str)){echo $val . '<br>';}
	}
}
echo '</div>';///////////
echo '<div>';////////////
start_form();
$ta = textarea('countWordsAlpha', 'cols="40" rows="5"');
echo '<br>';
button('btn9');
endForm();
if ($ta) {
	$sWord = [];
	$words = preg_split('/[\[\]\{\}\-:;\'><—,.?\/ \!@"_#$%^&()*+=|\\~`]{1}/iu' ,$ta, -1, PREG_SPLIT_NO_EMPTY);
	foreach ($words as $val){
		$firstSumbl = mb_substr($val, 0, 1, 'UTF-8');
		if (!isset($sWord[$firstSumbl])){
			$sWord[$firstSumbl][] = $val;
		} else {
			$sWord[$firstSumbl][] = $val;
		}
	}
	foreach($sWord as $key => $val){
		echo 'Слова на букву "' . $key . '"<br>';
		foreach($val as $words){
			echo '	' . $words . '<br>';
		}
	}
}

function toTranslit($ruStr , $reverse = false){
	$ru = ['а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'];
	$en =['a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'shh', '\'\'', 'y', '\'', 'e\'', 'yu', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'YO', 'ZH', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'CH', 'SH', 'SHH', '\'\'', 'Y', '\'', 'E\'', 'YU', 'YA'];
	if ($reverse){
		$temp = $ru;
		$ru = $en;
		$en = $temp;
	}
	return str_replace($ru, $en, $ruStr);
}

start_form();
$k3 = inp_tOp('text', 'translate', '', 'транслит');
button('btn10');
echo  '<br>';
if ($k3){
	echo $k3 . '<br>';
	$val = toTranslit($k3, 0);
	echo $val . '<br>';
}
endForm();





start_form();
$k3 = inp_tOp('text', 'translit', '', 'транслит');
echo  '<br>';
$r1 = radio('toTranslit', 'toEng', 'В английский');
echo  '<br>';
$r2 = radio('toTranslit', 'toRu', 'В русский');
echo  '<br>';
button('btn11');
echo '<br>';
if ($k3){
	if ($r1){echo toTranslit($k3, 0);}
	if ($r2){echo toTranslit($k3, 1);}
}
echo  '<br>';

endForm();



$arr = [['1+1=?', '2'],['4-5=?','-1'],['4*3=?','12'],['4/2=?','2'],['123+92=?','215'],['7^2=?','49'],['45-44=?','1']];
start_form();
$i = 0;
$r = [];
foreach($arr as $val){
	echo '<div style = "border: 1px solid black; float:none">' ;
	echo $val[0] . '<br>';
	if (!empty($_GET['ques1' . $i])){
		inp_tOp('hidden', 'ques1'.$i, $_GET['ques1' . $i], 'Ответ');
		echo 'Ваш ответ: ';
		if ($_GET['ques1' . $i] == $val[1]){
			echo '"' . $_GET['ques1' . $i] . '" - верно!<br>';
		} else {
			echo '"' . $_GET['ques1' . $i] . '" - неверно!<br>Правильный ответ: '. $val[1];
		}
	} else {
		inp_tOp('text', 'ques1'.$i, '', 'Ответ');
		echo '<br>';
	}
	echo '</div>';
	$i++;
}
button('');
endForm();
echo '</div>';///////////
echo '<div>';////////////
$arr = [['1+1=?', '0$2/3/4/5/6/7'],['4-5=?','1$6/4/1/9/6/2'],['4*3=?','3$8/8/8/87/7653/84'],['4/2=?','2$8/8/8/87/7653/84'],['123+92=?','4$8/8/8/87/7653/84'],['7^2=?','5$8/8/8/87/7653/84'],['45-44=?','1$8/8/8/87/7653/84']];
start_form();
$i = 0;
$r = [];
foreach($arr as $val){
	echo '<div style = "border: 1px solid black; float:none">' ;
	echo $val[0] . '<br>';
	$r[$i][0] = explode('$', $val[1]);
	$r[$i][1] = array_pop($r[$i][0]);
	$r[$i][1] = explode('/', $r[$i][1]);
	echo $r[$i][0][0] . '<br>';
	if (isset($_GET['ques3' . $i])){
		$ty = $_GET['ques3' . $i];
		inp_tOp('hidden', 'ques3'.$i, $ty, '');
		echo 'Ваш ответ: ';
		if ($ty == $r[$i][0][0]){
			echo '"' . $r[$i][1][$ty] . '" - верно!<br>';
		} else {
			echo '"' . $r[$i][1][$ty] . '" - неверно!<br>Правильный ответ: '. $r[$i][1][$r[$i][0][0]];
		}
	} else {
		$j=0;
		foreach ($r[$i][1] as $ans){
			radio('ques3'.$i, $j, $ans);
			$j++;
		}
		
		echo '<br>';
	}
	echo '</div>';
	$i++;
}

button('');
endForm();
echo '</div>';///////////
echo '<div style="width:200px">';////////////
$arr = [['1+1=?', '0$3$2/3/4/5/6/7/4/5/6/7/4/5/6/7/4/5/6/7/4/5/6/7'],['4-5=?','1$5$6/4/1/9/6/2'],['4*3=?','3$1$8/8/8/87/7653/84'],['4/2=?','2$1$8/8/8/87/7653/84'],['123+92=?','4$2$8/8/8/87/7653/84'],['7^2=?','5$3$8/8/8/87/7653/84'],['45-44=?','4$1$8/8/8/87/7653/84']];
start_form();
$i = 0;
$r = [];
foreach($arr as $val){
	echo '<div style = " border: 1px solid black;">' ;
	echo $val[0] . '<br>';
	$r[$i][0] = explode('$', $val[1]);
	$r[$i][1] = array_pop($r[$i][0]);
	$r[$i][1] = explode('/', $r[$i][1]);
	$rightAnsvers = [];
	foreach($r[$i][0] as $val){
		$rightAnsvers[] = $r[$i][1][$val];
	}
	$rightAnsvers = implode(', ', $rightAnsvers);
	if (isset($_GET['quesp'.$i])){
		$ty = $_GET['quesp'.$i];
		$givenAnsvers = [];
		$givenAnsversCount = count($ty);
		$kl = 0;
		foreach ($ty as $valTy){
			echo '<input type="hidden" name="quesp'.$i.'[]" value="'.$valTy.'">';
			$givenAnsvers[] = $r[$i][1][$valTy];
			if(in_array($valTy, $r[$i][0])){
				$kl++;
			}
		}
		$givenAnsvers = implode(', ', $givenAnsvers);
		if ($kl == 0){
			echo 'Ваш ответ: "' . $givenAnsvers . '" - неверно.<br>Правильный ответ: "'. $rightAnsvers . '"';
		} elseif ($kl == count($r[$i][0]) && count($r[$i][0]) == count($ty)){
			echo 'Ваш ответ: "'. $givenAnsvers .'" - верно!<br>';
		} else {
			echo 'Ваш ответ: "' . $givenAnsvers . '" - Частично верно.<br>Правильный ответ: "'. $rightAnsvers . '"';
		}
	} else {
		$j=0;
		foreach ($r[$i][1] as $ans){
			echo '<label style=" float:left; border: 1px solid black; padding: 2px">'.$ans.'<br><input type="checkbox" name="quesp'.$i.'[]" value="'.$j.'"></label>';
			$j++;
		}
	}
	echo '</div>';
	$i++;
}
button('');
endForm();
echo '</div>';///////////
echo '<div>';////////////


start_form();
$k3 = inp_tOp('text', 'factorial', '', 'Факториал');
button('');
if ($k3){
	$rez = 1;
	for ($i = $k3; $i>1; $i--){
		$rez *= $i;
	}
	echo $rez . '<br>';
}
endForm();
start_form();
$k1 = inp_tOp('text', 'kvadrYr1', '', 'a');
echo  '*x^2 + ';
$k2 = inp_tOp('text', 'kvadrYr2', '', 'b');
echo '*x + ';
$k3 = inp_tOp('text', 'kvadrYr3', '', 'c');
echo ' = 0;';
if ($k1 && $k2 && $k3){
	$diskriminant = $k2*$k2 - 4*$k1*$k3;
	if ($diskriminant >= 0){
		echo '<br>';
		$x1 = (-$k2 + sqrt($diskriminant))/(2*$k1);
		$x2 = (-$k2 - sqrt($diskriminant))/(2*$k1);
		echo $x1 . ', ' . $x2;
	} else {
		echo 'Корней нет!';
	}
}
echo '<br>';
button('');
endForm();


start_form();
echo 'Тройка пифагора' . '<br>';
$k1 = inp_tOp('text', 'troyka1', '', 'Число');
$k2 = inp_tOp('text', 'troyka2', '', 'Число');
$k3 = inp_tOp('text', 'troyka3', '', 'Число');
button('');
echo '<br>';
function isThirdOfPhifagor ($max, $num1, $num2){
	$sum = $num1 * $num1 + $num2 * $num2;
	$max *= $max;
	if ($max === $sum){
		return true;
	} else {
		return false;
	}
}
if ($k1 && $k2 && $k3){
	if ($k1 > $k2){
		if ($k1 > $k3){
			$max = $k1;
			$num1 = $k2;
			$num2 = $k3;
		} else {
			$max = $k3;
			$num1 = $k2;
			$num2 = $k1;
		}
	} elseif ($k2 > $k3){
		$max = $k2;
		$num1 = $k1;
		$num2 = $k3;
	} else {
		$max = $k3;
		$num1 = $k2;
		$num2 = $k1;
	}
	if (isThirdOfPhifagor ($max, $num1, $num2)){
		echo 'Да, это тройка Пифагора' . '<br>';
	} else {
		echo 'Нет, это не тройка Пифагора' . '<br>';
	}
}

endForm();
function getDivisors($num){
	$arr = [1];
	if ($num < 3){
		return $arr;
	}
	$lastDivider = '';
	for ($i = 2; true; $i++){
		if ($i == $num){
			return $arr;
		}
		if ($i == $num/$i){$arr[] = $i; break;}
		if ($lastDivider == $i){
			break;
		}
		if($num%$i == 0) {
			$arr[] = $i;
			$lastDivider = $num / $i;
			$arr[] = $lastDivider;
		}
	}
	sort($arr);
	return $arr;
}
start_form();
echo 'Список делителей числа' . '<br>';
$k1 = inp_tOp('text', 'dividers', '', 'Число');
button('');
echo '<br>';
if ($k1){
	$arter = getDivisors($k1);
	foreach ($arter as $val){
		echo $val . '<br>';
	}
}
endForm();
function arrayOfSimpleNumbers ($upperLimit = 1000){
	$arr = [2,3];
	$going = true;
	$i = 4;
	while ($going){
		$upLim = $i;
		$haveDividers = false;
		for ($j = 2; $j < $upLim; $j++){
			if ($i % $j == 0){
				$haveDividers = true;
			} else {
				$upLim = $i / $j;
			}
		}
		if (!$haveDividers){
			$arr[] = $i;
			if ($i >= $upperLimit){$going = false;}
		}
		$i++;
	}
	return $arr;
}





start_form();
echo 'Разложение на простые множители' . '<br>';
$k1 = inp_tOp('text', 'multiplier', '', 'Число');
button('');
echo '<br>';
$rez = [];
if ($k1){
	$arr = arrayOfSimpleNumbers(ceil($k1/2));
	$quotient = $k1;
	foreach ($arr as $simplDiv){
		$done = false;
		if ($quotient % $simplDiv == 0){
			$end = false;
			while (!$end){
				if ($quotient % $simplDiv == 0){
					$quotient = $quotient / $simplDiv;
					$rez[] = $simplDiv;
				} elseif ($quotient == 1) {
					$end = true;
					$done = true;
				} else {
					$end = true;
				}
			}
		}
		if ($done){break;}
	}
}
echo implode('*', $rez) . '<br>';
endForm();


start_form();
echo 'Общие делители 2 чисел' . '<br>';
$k1 = inp_tOp('text', 'commonDividers1', '', 'Число1');
$k2 = inp_tOp('text', 'commonDividers2', '', 'Число2');
button('');
echo '<br>';
if ($k1 & $k2){
	$k1 = getDivisors($k1);
	$k2 = getDivisors($k2);
	$result = array_intersect($k1, $k2);
	echo implode(', ', $result) . '<br>';
}

endForm();

start_form();
echo 'Наибольший общий делитель' . '<br>';
$k1 = inp_tOp('text', 'maxCommonDividers1', '', 'Число1');
$k2 = inp_tOp('text', 'maxCommonDividers2', '', 'Число2');
button('');
echo '<br>';
if ($k1 & $k2){
	$k1 = getDivisors($k1);
	$k2 = getDivisors($k2);
	$result = array_intersect($k1, $k2);
	echo max($result) . '<br>';
}
endForm();


start_form();
echo 'Наименьшее делимое 2 чисел' . '<br>';
$k1 = inp_tOp('text', 'dividend1', '', 'Число1');
$k2 = inp_tOp('text', 'dividend2', '', 'Число2');
button('');
echo '<br>';
if ($k1 & $k2){
	$max = max($k1, $k2);
	$min = min($k1, $k2);
	for ($i = 1; true; $i++){
		$kak = $max * $i;
		if ($kak % $min == 0){
			echo $kak . '<br>';
			break;
		}
	}
}



endForm();

start_form();
echo 'День недели' . '<br>';
$k1 = Sel_data($strtData = 1982, $endData = 2020);
button('');
echo '<br>';
if ($k1){
	$k1 = strtotime($k1);
	$arr = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
	echo $arr[date('w', $k1)] . '<br>';
}
endForm();


echo '</div>';///////////
echo '<div>';////////////

echo '<a href="scripting_task.php">clear</a>';
?>
</div>
</pre>

<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/practice/praktika-po-napisaniyu-prostyh-skriptov-php.html" target="_blank">Страница учебника</a></div>