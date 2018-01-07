<style>
	* {margin:0;padding:0}
	div {
		float:left;
		margin:5px;
		padding:5px;
		border: 1px solid black;
	}
</style>
<div>
<?php
/*--------------------------------------------------*/
echo time() . '<br>';;
echo mktime(12, 43, 59, 1, 31, 2017) . '<br>'; //31 января 2017, 12ч 43м 59с
echo mktime(12, 43, 59, 1, 31) . '<br>'; //31 января (текущего года), 12ч 43м 59с
echo mktime(12, 43, 59, 1) . '<br>'; //(текущая дата) января (текущего года), 12ч 43м 59с
echo mktime(12, 43, 59) . '<br>'; //(текущая дата) (текушего месяца) (текущего года), 12ч 43м 59с
echo time() - mktime(12, 0, 0, 2, 1, 2000) . '<br>';//разница между текущей датой и 1 февраля 2000года 12ч.0м.0с.
echo date('L') . '<br>';//выводит timestamp в нужном формате (L:високосный год?(0,1))
echo date('U') . '<br>';//timestamp
echo date('z') . '<br>';//номер дня от начала года
echo date('Y') . '<br>';//год, 4 цифры
echo date('y') . '<br>';//год, две цифры
echo date('m') . '<br>';//номер месяца (с нулем спереди)
echo date('n') . '<br>';//номер месяца без нуля впереди
echo date('d') . '<br>';//номер дня в месяце, всегда две цифры (то есть первая может быть нулем)
echo date('j') . '<br>';//номер дня в месяце без предваряющего нуля
echo date('w') . '<br>';//день недели (0 - воскресенье, 1 - понедельник и т.д.)
echo date('h') . '<br>';//часы в 12-часовом формате
echo date('H') . '<br>';//часы в 24-часовом формате
echo date('i') . '<br>';//минуты
echo date('s') . '<br>';//секунды
echo date('W') . '<br>';//порядковый номер недели года
echo date('t') . '<br>';// количество дней в указанном месяце
echo date('H:i:s d.m.Y', mktime(0,0,0,1,1,2001)) . '<br>';
echo strtotime('now') . '<br>';//Позволяет преобразовать строку в timestamp
echo strtotime('10 september 2000') . '<br>';
echo strtotime('+1 day') . '<br>';
echo strtotime('+1 week') . '<br>';
echo date('H:i:s d.m.Y', strtotime('+1 week 2 days 4 hours 2 seconds')) . '<br>';
echo strtotime('next thursday') . '<br>';
echo strtotime('last monday') . '<br>';
echo date('d-m-Y', strtotime("last Monday")) . '<br>';
$date = date_create('2025-12-31');//создает объект "Дата"
date_modify($date, '3 days');//Модифицирует объект дата
echo date_format($date, 'd.m.Y') . '<br>';//Выводит объект "Дата" в нужном формате
date_modify($date, '3 days 1 month');
echo date_format($date, 'd.m.Y') . '<br>';
date_modify($date, '-6 days -1 month');
echo date_format($date, 'd.m.Y') . '<br>';


?>
</div>
</pre>
<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/books/php/base/rabota-s-datami-v-php.html" target="_blank">Страница учебника</a></div>