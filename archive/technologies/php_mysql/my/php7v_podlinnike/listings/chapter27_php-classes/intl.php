<?php
echo '<span style="font-size: 100px;">'. IntlChar::ord($r = "ↈ") .': '. IntlChar::chr($r) . '</span><br>';

echo IntlChar::toupper('ё') . '<br>';
echo IntlChar::tolower('Ё') . '<br>';
echo (IntlChar::isalnum('~') ? 'true' : 'false') . '<br>'; //буква или цифра
echo (IntlChar::isalpha('ё') ? 'true' : 'false') . '<br>'; //буква
echo (IntlChar::isspace('	') ? 'true' : 'false') . '<br>'; //пробельный символ
echo (IntlChar::iscntrl("\r") ? 'true' : 'false') . '<br>'; //управляющий символ
echo (IntlChar::ispunct(",") ? 'true' : 'false') . '<br>'; //пунктуация
