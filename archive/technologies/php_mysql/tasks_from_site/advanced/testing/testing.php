<html lang="ru">
<div style="width: 100%; border: none">
<div style="width: 676px; margin: 0 auto; float: none; border: none">


<?php
date_default_timezone_set('Europe/Moscow');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$headers = apache_request_headers();
$str = '+' . $headers['User-Agent']. '; ' . date('H:i:s d.m.Y', $_SERVER['REQUEST_TIME']). PHP_EOL;
if (isset($headers['Referer'])){
	$str .= $headers['Referer'];
	$str .= PHP_EOL;
}
if (!empty($_REQUEST)){
	foreach($_REQUEST as $key=>$val){
		$str .= $key . ' - ' . $val . '; ';
	}
	$str .= PHP_EOL;
}
$ip = $_SERVER['REMOTE_ADDR'];
file_put_contents('testing_files/ansvers/'.$ip.'.txt', $str, FILE_APPEND);



include('input_functions_for_testing.php');

start_form();
$q1 = questions_test('four', 'Сколько будет 2 + 2 х 2?', ' 8; 5; 4; 6', 4);
questions_test('point', 'В чем смысл жизни?', ' В продлжении рода; В получении удовольствия; В самосовершенствовании; В развитии человечества', 4);
questions_test('phpLearn', 'Сколько требуется времени чтобы выучить PHP?', ' 3 дня; 5 месяцев; 23 недели; Незнаю', 4);
questions_test('sauce', 'The best sauce of my life?', 'kepchuk;mazik;kitchunez;voda', 2, 'twotr');
questions_test('whyMoney', 'Зачем нужны деньги?', ' Чтобы поесть; Чтобы телки давали; Чтобы легко обмениваться товарами; Чтобы сделать людей рабами', 2);
questions_test('rain', 'Here comes the rain again...', ' Falling on my head like a memory; Falling on my head like a new emotion; Это не вопрос; Незнаю', 3);
questions_test('drink', 'Что люди пьют когда им хорошо?', 'Прану;Жигулевское;Слезы врагов;Смузи', 2, 'twotr');
questions_test('rules', 'Зачем придуманы правила?', ' Чтобы их нарушать; Чтобы бедный не мог навредить богатому; Чтобы люди могли жить в мире и согласии; прост ))))0)))00))000', 4);
questions_test('happy', 'Что нужно человеку для счастья?', ' Развлечения; Комфорт; Деньги; Власть', 0);
button('send_test');
endForm();

?>


</div>
</div>