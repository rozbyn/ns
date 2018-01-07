<?php
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

function textarea ($name, $tags){
	$val = '';
	if (isset($_GET[$name])){
		if (!empty($_GET[$name])){
				$val = $_GET[$name];
			} else {
				$val = '';
			}
	}
	echo '<textarea name="'.$name.'" '.$tags.'>'.$val.'</textarea>';
	return $val;
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
echo '<style>
* {margin:0;padding:0}
div {
	float:left;
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
.onetr {
	margin:5px;
	padding:5px;
	width: 200px;
	float:left;
}.twotr {
	margin:5px;
	padding:5px;
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
function questions_test ($name = 'test_name', $question_text = 'what next?', $ans = 'sleep;eat;work;eat more', $right = 1, $div_class = 'onetr'){
	$class = array_fill(1, 4, 'test_questions');
	$mess = '-';
	$ans = explode(';', $ans);
	$ans2 = '';
	if (!empty($_GET[$name])){
		$ans2 = $_GET[$name];
		if ($right != 0){
			$class[$right] = 'test_questions_right';
			$mess = 'Верно!';
			if ($_GET[$name] != $right){
				$class[$_GET[$name]] = 'test_questions_wrong';
				$mess = 'Неправильно!';
			}
		}
	}
	echo '<div class = "'.$div_class.'">';
	echo '<p class="questions">'.$question_text.'</p>';
	
	radio($name, 1, $ans[0], '', $class[1]); 
	radio($name, 2, $ans[1], '', $class[2]); 
	radio($name, 3, $ans[2], '', $class[3] . '" style = "clear: left'); 
	radio($name, 4, $ans[3], '', $class[4]); 
	echo '<text class="clears">'. $mess . '</text></div>';
	return $ans2;
}

?>