<?php
date_default_timezone_set('Europe/Moscow');

//$myDbObj = connect_DB('test', 'root', '', 'localhost');
//$myDbObj = connect_DB('u784337761_test', 'u784337761_root', 'nSCtm9jplqVA', 'localhost');

//ФИГУРНЫЕ СКОБКИ
/*
оператор {}, указывающий количество повторений. 
Работает он следующим образом: {5} – пять повторений, {2,5} – повторяется от двух до пяти (оба включительно),
{2,} - повторяется два и более раз. Обратите внимание на то, что такого варианта - {,2} - нет.
*/
echo '1. '.preg_replace('#xa{1,2}x#', '!', 'xx xax xaax xaaax'). '<br>'; //выведет 'xx ! ! xaaax'
//буква 'x', буква 'a' один или два раза, буква 'x'. 

echo '2. '.preg_replace('#xa{2,}x#', '!', 'xx xax xaax xaaax'). '<br>'; //выведет 'xx xax ! !'
//буква 'x', буква 'a' два раза и более, буква 'x'. 

echo '3. '.preg_replace('#xa{2}x#', '!', 'xx xax xaax xaaax'). '<br>';//выведет 'xx xax ! xaaax'
//буква 'x', буква 'a' два раза, буква 'x'. 

echo '4. '.preg_replace('#xa{0,2}x#', '!', 'xx xax xaax xaaax'). '<br>';
// буква 'x', буква 'a' ноль, один или два раза, буква 'x'. 


//Группы символов \s, \S, \w, \W, \d, \D
// \d означает 'цифра от 0 до 9', а \D – наоборот, 'не цифра'

echo '5. '.preg_replace('#\d+#', '!', '1 12 123 abc @@@'). '<br>';//выведет '! ! ! abc @@@'
//цифра от 0 до 9 один или более раз. 

echo '6. '.preg_replace('#\D+#', '!', '123abc3@@'). '<br>';//выведет '123!3!'
//все что угодно, но не цифра от 0 до 9, один или более раз. 
//"\s" Обозначает пробел или пробельный символ (имеется ввиду перевод строки, табуляция и т.п.) 
//"\S" Не пробел, то есть всё, кроме \s. 
//"\w" Цифра или буква (внимание: сюда не входит кириллица! Это можно исправить с помощью 
//функции setlocale при большом желании.) 
//"\W" Не цифра и не буква. 


echo '7. '.preg_replace('#\s#', '!', '1 12 123 abc @@@'). '<br>';//выведет '1!12!123!abc!@@@'
//пробельный символ один раз. 

echo '8. '.preg_replace('#\S+#', '!', '1 12 123 abc @@@'). '<br>';//выведет '! ! ! ! !'
//НЕ пробельный символ один или более раз. Все подстроки, разделенные пробелами, заменятся на '!'. 

echo '9. '.preg_replace('#\w+#', '!', '1 12 123a Abc @@@'). '<br>';//выведет '! ! ! ! @@@'
//цифра или буква один или более раз. 

echo '10. '.preg_replace('#\W+#', '!', '1 12 123 Abc @@@'). '<br>';//выведет '1!12!123!Abc!'
//НЕ цифра и НЕ буква один или более раз.

//Квадратные скобки '[' и ']' (операция ИЛИ)
echo '11. '.preg_replace('#[abc]xx#', '!', 'axx bxx cxx exx'). '<br>';//выведет '! ! ! exx'
//первый символ - это буква 'a', 'b' или 'c', потом две буквы 'x'. 

//С помощью шляпки '^' мы можем сделать отрицание: 
echo '12. '.preg_replace('#[^abc]xx#', '!', 'axx bxx cxx exx'). '<br>';//выведет 'axx bxx cxx !'
//первый символ - это НЕ буква 'a', 'b' или 'c' (любой символ кроме них), потом две буквы 'x'. 

/*
    Можно задавать группы символов: [a-z] задаст маленькие латинские буквы, 
	[A-Z] – большие, [0-9] – цифру от 0 до 9.
    Посложнее: [a-zA-Z] – большие и маленькие латинские буквы, 
	то же самое плюс цифры - [a-zA-Z0-9], и так далее. 
	Порядок значения не имеет, нет разницы [a-zA-Z] или [A-Za-z].
    Еще посложнее: [2-5] - цифра от 2-х до 5-ти (обе включительно), 
	[a-c] – буквы от 'a' до 'c' по алфавиту (то есть 'a', 'b', 'c') и так далее.
*/

//Шляпка - это спецсимвол внутри [ ] (снаружи, кстати, тоже). 
//Если вам нужна шляпка как символ - просто поставьте ее не в начале 
//(она спецсимвол только вначале: [^d] – так спецсимвол, а [d^] - так уже нет!). 

echo '13. '.preg_replace('#[^d]xx#', '!', 'axx bxx ^xx dxx'). '<br>';//выведет '! ! ! dxx'
//первый символ - это все кроме 'd', потом две буквы 'x'. 

echo '14. '.preg_replace('#[d^]xx#', '!', 'axx bxx ^xx dxx'). '<br>';//выведет 'axx bxx ! !'
//первый символ - это 'd' или '^', потом две буквы 'x'. 

echo '15. '.preg_replace('#[\^d]xx#', '!', 'axx bxx ^xx dxx'). '<br>';//выведет 'axx bxx ! !'
//первый символ - это 'd' или '^', потом две буквы 'x'. 

/*
	Дефис - тоже спецсимвол внутри [ ] (а вот снаружи - нет!). Если вам нужен сам дефис как символ - 
	то поставьте его там, где он не будет воспринят как разделитель группы, 
	например, в начале или в конце (то есть после [ или перед ]).
	Почему это важно: вы можете сделать группу символов, сами не заметив этого. 
	К примеру, вот так - '[:-@]' - вы думаете, что выбираете двоеточие, дефис и собаку @, 
	а на самом деле получается группа символов между : и @. 
	В эту группу входят следующие символы: ":, ;, <, =, >, ?". 
*/

echo '16. '.preg_replace('#[a-zA-Z-]xx#', '!', 'axx Axx -xx @xx'). '<br>';//выведет '! ! ! @xx'
//первый символ - это маленькие, большие буквы или дефис '-', потом две буквы 'x'. 

echo '17. '.preg_replace('#[a-z-0-9]xx#', '!', 'axx 9xx -xx @xx'). '<br>';//выведет '! ! ! @xx'
//первый символ - это маленькие латинские, дефис '-' или цифра от 0 до 9, потом две буквы 'x'. 
/*
	Можно также заэкранировать дефис - тогда он будет обозначать сам себя независимо от позиции. 
	Например, вместо '[:-@]' написать '[:\-@]' - и группы уже не будет, 
	а будут три символа - двоеточие, дефис и собака @. 
	Спецсимволы внутри [ ] становятся обычными символами (значит их не надо экранировать обратным слешем!).
	Исключение из предыдущего: [ ] имеют свои спецсимволы - это '^' и '-', 
	кроме того, если вам нужны квадратные скобки как символы внутри [ ] - 
	то их нужно экранировать обратным слешем.
	Еще исключение: группы символов \s, \S, \w, \W, \d, \D (и другие аналогичные) 
	будут обозначать именно группы, то есть по-прежнему будут командами. 
*/

echo '18. '.preg_replace('#[\da-z]xx#', '!', '3xx axx Axx'). '<br>';//выведет '! ! Axx'
//первый символ - это цифра от 0 до 9 (\d) или маленькая латинская буква (a-z), потом две буквы 'x'. 

//Особенности кириллицы
/*
	Первое: кириллица не входит в \w, нужно делать так: [а-яА-Я].
	Второе: так сделать недостаточно [а-яА-Я] - сюда не войдет буква ё, нужно делать так: [а-яА-ЯЁё].
	Если нужны только маленькие буквы - тогда просто [а-яё].
	Третье: PHP не любитель работать с кириллицей, поэтому, чтобы все работало корректно - 
	нужно ставить модификатор 'u' (именно маленькая буква): 
*/
echo '18. '.preg_replace('#[а-яА-ЯЁё]яя#u', '!', 'аяя ёяя 2яя'). '<br>';//выведет '! ! 2яя'
//первый символ - это цифра кириллическая буква, потом две буквы 'я'. 

//Существуют специальные символы, которые обозначают начало '^' или конец строки '$'. 
echo '19. '.preg_replace('#^aaa#', '!', 'aaa aaa aaa'). '<br>';//выведет '! aaa aaa'
//заменить 'aaa' на '!' только если оно стоит в начале строки. 

echo '20. '.preg_replace('#aaa$#', '!', 'aaa aaa aaa'). '<br>';//выведет 'aaa aaa !'
//заменить 'aaa' на '!' только если оно стоит в конце строки. 

echo '21. '.preg_replace('#^a+$#', '!', 'aaa'). '<br>';//выведет '!'
//буква 'a' повторяется один или более раз, заменить всю строку на '!' только она состоит из одних букв 'a'. 

//Квадратные скобки не единственный вариант сделать 'или': существует еще вариант через вертикальную черту '|': 
echo '22. '.preg_replace('#a|b+|c#', '!', 'bbbb'). '<br>';//выведет '!'
//если вся строка - это 'a', или вся строка - один или более букв 'b', или вся строка - это 'c', 
//то заменить ее на '!'. 

/*
В данном случае 'или' действует на все регулярное выражение (по сути у нас три регулярки в одной). 
Можно работать и по-другому - поставим круглые скобки, и теперь '|' будет действовать только внутри них: 
*/
echo '23. '.preg_replace('#(a|b+)xx#', '!', 'axx aaxx bxx bbxx exx'). '<br>';//выведет '! a! ! ! exx'
//в начале стоит или 'a', или 'b' один или более раз, а потом две буквы 'x'. 


//Команда \b обозначает начало или конец слова, а \B, соответственно, - не начало и не конец слова.
echo '24. '.preg_replace('#\b[a-z]+\b#', '!', 'axx bxx xxx exx'). '<br>';//выведет '! ! ! !'
//начало слова, маленькие латинские один или более раз, конец слова. 

//Проблема обратного слеша
echo '26. '.preg_replace('#\\\\#', '!', '\\ \\ \\\\'). '<br>';//выведет '! ! !!'
//Шаблон поиска такой: обратный слеш один раз. 
/*
	Обратите внимание на '\\ \\ \\\\' - мы удваиваем все слеши для PHP, 
	и в реальности строка выглядит так: '\ \ \\', 
	поэтому в ответе будет '! ! !!', а не '!! !! !!!!'. 
*/
echo '27. '.preg_replace('#\\\\+#', '!', '\\ \\ \\\\'). '<br>';//выведет '! ! !'
//Шаблон поиска такой: обратный слеш один или более раз. 

//Функция preg_replace имеет 4-тый необязательный параметр, который указывает, сколько замен произвести: 
echo '28. '.preg_replace('#a+#', '!', 'a aa aaa aaaa', 2). '<br>';//выведет '! ! aaa aaaa'
//Функция произвела только две замены, все остальное не заменилось 
//('aaa' и 'aaaa' попали под регулярку но не поменялись на '!'). 

echo '29. '.preg_replace('#a+#', '!', 'a aa aaa aaaa', 3). '<br>';//выведет '! ! ! aaaa'
//Ну, а теперь 3 замены.









?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Регулярные выражения</title>
   
</head>
<body >
	<div class="main">
		<div class="wrapper">

		</div>
	</div>
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/books/php/regular/rabota-s-regulyarnymi-vyrazeniyami-v-php-glava-1.html" target="_blank">Страница учебника</a></div>
</body>
</html>