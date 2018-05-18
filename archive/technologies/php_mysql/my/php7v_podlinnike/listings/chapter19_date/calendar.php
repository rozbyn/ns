<?php
$locale = setlocale(LC_ALL, 'RU', 'Russian_Russia.1251');
date_default_timezone_set('Europe/Moscow');

function strftime_utf8 ($format, $tmstmp = false, $charset = 'cp1251') {
	if ($tmstmp == false) {
		$tmstmp = time();
	}
	$format = iconv('utf-8', $charset, $format);
	$str = strftime($format, $tmstmp);
	$str = iconv($charset,'utf-8', $str);
	return $str;
}

 ## Календарь на текущий месяц.
  // Функция формирует двумерный массив, представляющий собой
  // календарь на указанный месяц и год. Массив состоит из строк,
  // соответствующих неделям. Каждая строка - массив из семи 
  // элементов, которые равны числам (или пустой строке, если
  // данная клетка календаря пуста).
  function makeCal($year, $month) {
    // Получаем номер дня недели для 1 числа месяца.
    $wday = date('N');
    // Начинаем с этого числа в месяце (если меньше нуля 
    // или больше длины месяца, тогда в календаре будет пропуск).
    $n = - ($wday - 2);
    $cal = [];
    // Цикл по строкам.
    for ($y = 0; $y < 6; $y++) {
      // Будущая строка. Вначале пуста.
      $row = [];
      $notEmpty = false;
      // Цикл внутри строки по дням недели.
      for ($x = 0; $x < 7; $x++, $n++) {
        // Текущее число >0 и < длины месяца?
        if (checkdate($month, $n, $year)) {
          // Да. Заполняем клетку.
          $row[] = $n;
          $notEmpty = true;
        } else {
          // Нет. Клетка пуста.
          $row[] = "";
        }
      }
      // Если в данной строке нет ни одного непустого элемента,
      // значит, месяц кончился.
      if (!$notEmpty) break;
      // Добавляем строку в массив.
      $cal[] = $row;
    }
    return $cal;
  }
  
	function getCalendar ($month = null, $year = null) {
		$months = [1=>31,28,31,30,31,30,31,31,30,31,30,31];
		$leap_year = false;
		//Проверяем введеные значения, 
		//если null или не действительный номер месяца или года
		//присваиваем текущие значения
		if (is_null($month) || $month < 1 || $month > 12) $month = date('n');
		else $month = (int) $month;
		if (is_null($year)) $year = date('Y');
		else $year = (int) $year;
		//если месяц Февраль то проверяем год на високосность
		//и присваиваем 29 дней в месяце, либо 28
		if ($month == 2 && ($year % 400 == 0 ||	($year % 4 == 0 && $year % 100 != 0))) 
			$monthCount = 29; //дней в Феврале месяце в високосный год
		else 
			$monthCount = $months[$month]; //дней в месяце
		//переводим дату в формат Julian Day Count чтобы узнать день недели первого числа месяца
		$firstDayWeek = JDDayOfWeek(GregorianToJD($month, 1, $year));
		//если воскресенье то номер = 7
		$firstDayWeek = ($firstDayWeek === 0) ? 7 : $firstDayWeek; 
		//создаем массив с числами от 1 до количества дней в месяце
		$arrMonth = range(1, $monthCount);
		//создаём массив с пустыми строками, в колчичестве равном
		//числу дней предшествующих первому числу месяца на первой неделе
		$arrEmptyStrings = array_pad([], ($firstDayWeek - 1), '');
		//соединяем оба массива
		$arrMonth = array_merge($arrEmptyStrings, $arrMonth);
		//делим массив на куски по 7 элементов
		$arrMonth = array_chunk($arrMonth, 7);
		//выбираем последнюю неделю и дополняем её до размера 7 пустыми строками
		$lastWeek = count($arrMonth)-1;
		$arrMonth[$lastWeek] = array_pad($arrMonth[$lastWeek], 7, '');
		//присоединяем к массиву название месяца, года и возвращаем результат
		$arrMonth[] = date('M', mktime(0,0,0,$month,1,2000)) . ", $year";
		return $arrMonth;
	}
  // Формируем календарь на текущий месяц.
  //$now = getdate();
  //$cal = makeCal($now['year'], $now['mon'] - 1);
  //$cal = makeCal(2004, 6);
  //$cal = getCalendar(5, 2017); //начинается с понедельника
  //$cal = getCalendar(4, 2018); //начинается с воскресенья
  //$cal = getCalendar(5, 2018); //начинается со вторника
  //$cal = getCalendar(6, 2018); //начинается с пятницы
  for ($i = 1; $i < 13; $i++) {
	  $calend[] = getCalendar($i, 2019); 
  }
if (true) {
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <title>Использование функции strtotime()</title>
  <meta charset='utf-8'>
</head>
<body>
<div style="display: flex; flex-wrap: wrap">
<?php foreach ($calend as $cal) { ?>
<div  style="margin: 10px">
  <table border='1'>
  <caption>
	<?= array_pop($cal); ?>
  </caption>
    <tr>
      <td>Пн</td>
      <td>Вт</td>
      <td>Ср</td>
      <td>Чт</td>
      <td>Пт</td>
      <td>Сб</td>
      <td style="color:red">Вс</td>
    </tr>
    <!-- цикл по строкам -->
    <?php foreach ($cal as $row) {?>
      <tr>
        <!-- цикл по столбам -->
        <?php foreach ($row as $i => $v) {?>
          <!-- воскресенье - "красный" день -->
          <td style="<?= $i == 6 ? 'color:red' : '' ?>">
            <?= $v ? $v : "&nbsp;" ?>
          </td>
        <?php } ?>
      </tr>
    <?php } ?>
  </table>
</div>

<?php } ?>
</div>
</body>
</html>
<?php } ?>

