<html lang="ru">
<style>
	* {margin:0;padding:0}
	div {
		float:left;
		margin:5px;
		padding:5px;
		border: 1px solid black;
	}
	form {
		padding:3px;
		border: 2px solid green;
	}
	input {
		position: relative;
		top: 1px;
	}
</style>
<div>
<?php
if (empty($_GET['sub1'])){
	$ch = 'checked';
	$name = '';
	$str = '';
} else {
	if (!empty($_GET['test'])){
		$ch = 'checked';
		$str = 'Привет';
	} else {
		$ch = '';
		$str = 'Пока';
	}
	if (!empty($_GET['name'])){
		$name = $_GET['name'];
		$str .= ', ' . $name;
	} else {
		$name = '';
	}
	$str .= '!';
}
echo '
<form name = "user" action="" method = "GET">
	<input type="checkbox" name="test" value ="1" ' . $ch . '>
	<input type="text" name="name" value ="' . $name . '">
	<input type="submit"  name = "sub1" value ="Отправить"><br>';
echo $str . '</form>';
$ch_h = '';
$ch_c = '';
$ch_j = '';
$ch_p = '';
if (empty($_GET['sub2'])){
	$str = '';
} elseif(empty($_GET['lang'])){
	$str = 'Вы не выбрали ни одного языка!';
} else {
	$arr = [];
	if (in_array('1', $_GET['lang'])){$ch_h = 'checked';$arr[] = 'HTML';}
	if (in_array('2', $_GET['lang'])){$ch_c = 'checked';$arr[] = 'CSS';}
	if (in_array('3', $_GET['lang'])){$ch_j = 'checked';$arr[] = 'JAVASCRIPT';}
	if (in_array('4', $_GET['lang'])){$ch_p = 'checked';$arr[] = 'PHP';}
	$str = 'Вы выбрали:<br>' . implode(', ', $arr) . '.';
}
echo '
<form name = "userLang" action="" method = "GET">
	<p>Какие языки программирования вы знаете?<br></p>
	<label><input type="checkbox" name="lang[]" value = "1" ' . $ch_h . '> HTML</label><br>
	<label><input type="checkbox" name="lang[]" value = "2" ' . $ch_c . '> CSS</label><br>
	<label><input type="checkbox" name="lang[]" value = "3" ' . $ch_j . '> JAVASCRIPT</label><br>
	<label><input type="checkbox" name="lang[]" value = "4" ' . $ch_p . '> PHP</label><br>
	<input type="submit"  name = "sub2" value ="Отправить"><br>';
echo $str . '</form>';
$kwPhp1 = '';
$kwPhp0 = 'checked';
if (empty($_GET['sub3'])){
	$str = '';
} elseif ($_GET['php'] == '1'){
	$kwPhp1 = 'checked';
	$kwPhp0 = '';
	$str = 'Вы ответили, что знаете PHP.';
} else {
	$str = 'Вы ответили, что не знаете PHP.';
}
echo '
<form name = "knowPhp?" action="" method = "GET">
	<p>Вы знаете PHP?<br></p>
	<label><input type="radio" name="php" value = "1" ' . $kwPhp1 . '> Да</label>
	<label><input type="radio" name="php" value = "0" ' . $kwPhp0 . '> Нет</label><br>
	<input type="submit"  name = "sub3" value ="Отправить"><br>';
echo $str . '</form>';
$ages = ['','','',''];
$a2 = ['менее 20', '20-25', '26-30', 'более 30'];
if (empty($_GET['sub4'])){
	$str = '';
} elseif (!isset($_GET['age'])){
	$str = 'Вы не указали свой возраст.';
} else {
	$ages[$_GET['age']] = 'checked';
	$str = 'Вам ' . $a2[$_GET['age']] . ' лет.';
}
echo '
<form name = "age" action="" method = "GET">
	<p>Сколько вам лет?<br></p>
	<label><input type="radio" name="age" value = "0" ' . $ages[0] . '> менее 20</label><br>
	<label><input type="radio" name="age" value = "1" ' . $ages[1] . '> 20-25</label><br>
	<label><input type="radio" name="age" value = "2" ' . $ages[2] . '> 26-30</label><br>
	<label><input type="radio" name="age" value = "3" ' . $ages[3] . '> более 30</label><br>
	<input type="submit"  name = "sub4" value ="Отправить">';
echo $str . '</form>';

$ages2 = ['','','',''];
if (empty($_GET['sub5'])){
	$str = '';
} else {
	$ages2[$_GET['age2']] = 'selected';
	$str = 'Вам ' . $a2[$_GET['age2']] . ' лет.';
}
echo '
<form name = "age2" action="" method = "GET">
	<p>Сколько вам лет?<br></p>
	<select name = "age2">
		<option value="0"' . $ages2[0] . '>менее 20</option>
		<option value="1"' . $ages2[1] . '>20-25</option>
		<option value="2"' . $ages2[2] . '>26-30</option>
		<option value="3"' . $ages2[3] . '>более 30</option>
	</select>
	<input type="submit"  name = "sub5" value ="Отправить">';
echo $str . '</form>';

$lang_2 =['','','',''];
$a2 = ['HTML', 'CSS', 'JAVASCRIPT', 'PHP'];
if (empty($_GET['sub6'])){
	$str = '';
} elseif (!isset($_GET['lang2'])){
	$str = 'Вы не выбрали ни одного языка!';
} else {
	$str1 = implode(', ', $_GET['lang2']);
	$str1 = str_replace([0, 1, 2, 3], $a2, $str1);
	if (in_array('0', $_GET['lang2'])){$lang_2[0] = 'selected';}
	if (in_array('1', $_GET['lang2'])){$lang_2[1] = 'selected';}
	if (in_array('2', $_GET['lang2'])){$lang_2[2] = 'selected';}
	if (in_array('3', $_GET['lang2'])){$lang_2[3] = 'selected';}
	$str = 'Вы выбрали: ' . $str1 . '.';
}
echo '
<form name = "lang2" action="" method = "GET">
	<p>Какие языки программирования вы знаете?<br></p>
	<select name = "lang2[]" multiple>
		<option value="0"' . $lang_2[0] . '>HTML</option>
		<option value="1"' . $lang_2[1] . '>CSS</option>
		<option value="2"' . $lang_2[2] . '>JAVASCRIPT</option>
		<option value="3"' . $lang_2[3] . '>PHP</option>
	</select><br>
	<input type="submit"  name = "sub6" value ="Отправить">';
echo $str . '</form>';

function inp_tOp($type = 'text', $name = 'exampe', $value = 'example value', $placeholder = 'exampe placeholder'){
	$a = false;
	if (isset($_GET[$name])){
		$value = $_GET[$name];
		if (!empty($_GET[$name])){
			$a = $value;
		}
	}
	echo '<input type="' . $type . '" name="' . $name . '" value ="' . $value . '" placeholder = "' . $placeholder . '">';
	return $a;
}

function chk_box ($name = 'exampl_chkbox', $checked = ''){
	if (isset($_GET[$name])){
		if ($_GET[$name] == 0){
				$checked = '';
			} else {
				$checked = 'checked';
			}
	}
	echo'
	<input type="hidden" name="' . $name . '" value="0" ' . $checked . '>
	<input type="checkbox" name="' . $name . '" value="1" ' . $checked . '>
	';
	return $checked==true;
}

function start_form($name = '', $method = 'GET'){
	echo '<form name = "'.$name.'" action="" method = "GET" style="float: left">';
}

function endForm(){
	echo '</form>';
}

function button($name = 'btn0', $value = 'Отправить'){
	echo '<input style = "float: left; clear: both" type="submit"  name = "'.$name.'" value ="'.$value.'">';
}

function radio($name = 'radio0', $value = '0', $text = '', $chkd = '', $class = ''){
	if(isset($_GET[$name])){
		if ($_GET[$name] == $value){
			$chkd = 'checked';
		} else {
			$chkd = '';
		}
	}
	echo '<label class="'.$class.'"><input type="radio" name="'.$name.'" value="'.$value.'" '.$chkd.'>'.$text.'</label>';
	return $chkd==true;
}

function select($name = 'select0', $opt = 'Текст 1,1,0;Текст 2,2,0;Текст 3,3,1', $mltpl = ''){
	$name0 = $name;
	$retArr = [];
	if ($mltpl){
		$mltpl = 'multiple';
		$name0 .= '[]';
		echo '<input type="hidden" name="'.$name0.'" value="0">';
	}
	echo '<select name="'.$name0.'" '.$mltpl.'>';
	$arr = explode(';', $opt);
	foreach($arr as $val){
		$opArr = explode(',', $val);
		$sel = '';
		if(isset($_GET[$name])){
			if (is_array($_GET[$name])){
				if (in_array($opArr[1], $_GET[$name])){
					$sel = 'selected';
					$retArr[] = $opArr[1];
				}
			} else {
				if($opArr[1] == $_GET[$name]){
					$sel = 'selected';
					$retArr[] = $opArr[1];
				}
			}
		} else {
			if ($opArr[2]){$sel = 'selected';}
		}
		echo '<option value="'.$opArr[1].'" '.$sel.'>'.$opArr[0].'</option>';
	}
	echo '</select>';
	return $retArr;
}

function Sel_data($strtData = 1982, $endData = 2020){
	$today_day = date('d');
	$today_month = date('m');
	$today_year = date('Y');
	
	$str_day = range(1,31);
	foreach($str_day as $key => $val){
		$sel = '0';
		if ($val == $today_day){$sel = '1';}
		$str_day[$key] .= ','.$val.','.$sel;
	}
	$str_day = implode(';',$str_day);
	$str_month = range(1,12);
	$month = [1=>'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
	foreach ($str_month as $key=>$val){
		$sel = '0';
		if ($val == $today_month){$sel = '1';}
		$str_month[$key] = $month[$val] . ',' . $val . ',' . $sel;
	}
	$str_month = implode(';',$str_month);
	$str_year = range($strtData, $endData);
	foreach ($str_year as $key => $val){
		$sel = '0';
		if ($val == $today_year){$sel = '1';}
		$str_year[$key] .= ','.$val.','.$sel;
	}
	$str_year = implode(';',$str_year);
	start_form();
	$selected_day = select('day',$str_day);
	$selected_month = select('month',$str_month);
	$selected_year = select('year',$str_year);
	button('snd_date');
	if ($selected_day && $selected_month && $selected_year){
		$selected_date = $selected_day[0] . '-' . $selected_month[0] . '-' . $selected_year[0];
		echo $selected_date;
		endForm();
		return $selected_date;
	}
	endForm();
}

echo '<form name = "test_f" action="" method = "GET">';
inp_tOp('text', 'hello', '', 'Ваше приветствие');
chk_box('wood');
echo '<input type="submit"  name = "sub7" value ="Отправить">';
echo '</form>';
echo '
<form name = "log_and_pass" action="" method = "GET">
<p>Введите логин и пароль</p>';
$log_entered = inp_tOp('text', 'login', '', 'Введите логин');
echo '<br>';
$pass_entered = inp_tOp('password', 'pas1', '', 'Введите пароль');
echo '<br><label>';
$remember = chk_box('remember');
echo 'Запомнить?</label><br><input type="submit"  name = "sub8" value ="Отправить"><br>';
if ($log_entered && $pass_entered && $remember){
	echo 'Мы вас запомнили, сука: ' . $log_entered . ', ' . $pass_entered . '<br>';
}
echo '</form>';

echo '</div>';
echo '<div>';


echo '<form name = "test_f" action="" method = "GET"><BR>Какие языки вы знаете?<br>';
echo '<label>'; $ru = chk_box('ru', 'checked'); echo ' Русский</label><br>';
echo '<label>'; $en = chk_box('en'); echo ' Английский</label><br>';
echo '<label>'; $de = chk_box('de'); echo ' Немецкий</label><br>';
echo '<label>'; $fr = chk_box('fr'); echo ' Французский</label><br>';
echo '<input type="submit"  name = "sub9" value ="Отправить"><br>';
$arr=[];
if (!empty($_GET['sub9'])){
	if ($ru || $en || $de || $fr){
		if ($ru){$arr[]  = 'Русский';}
		if ($en){$arr[]  = 'Английский';}
		if ($de){$arr[]  = 'Немецкий';}
		if ($fr){$arr[]  = 'Французский';}
		echo 'Вы выбрали: ' . implode(', ', $arr) . '.';
	} else {
		echo 'Вы не выбрали ни одного языка!';
	}
}
echo '</form>';

start_form();
select('pox1', 'Текст 1,1,0;Текст 2,2,0;Текст 3,3,1');
echo  '<br>';
select('pox', 'Вариант 1,1,0;Вариант 2,2,0;Вариант 3,3,0;Вариант 4,4,0', 'multiple');
echo '<br>';
button('fggh');
endForm();

echo '</div>';
echo '<div>';
echo '<style>
.onetr {
	width: 200px;
	float:left;
}.twotr {
	width: 200px;
	clear:left;
}

.test_questions_right, .test_questions_wrong, .test_questions{
		float: left;
		border-radius: 2px;
		margin: 2px;
		padding: 2px;
		display: block;
		-moz-hyphens: auto;
		-webkit-hyphens: auto;
		-ms-hyphens: auto;
	}
.test_questions_right {
		background-color: lightgreen;
	}
.test_questions_wrong {
		background-color: lightsalmon;
	}
.test_questions {
		background-color: blanchedalmond;
	}
	.questions{
		margin: 5px;
		margin-bottom: 10px;
	}
.clears {
	margin: 0;
	padding: 0;
	float: left;
	clear: both;
}
</style>';


?>
</div>
</pre>
</html>
<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/base/prodvinutaya-rabota-s-formami-v-php.html" target="_blank">Страница учебника</a></div>