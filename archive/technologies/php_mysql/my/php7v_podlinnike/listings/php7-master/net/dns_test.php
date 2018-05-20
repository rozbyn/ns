<?php
echo gethostbyaddr('87.250.250.242') . '<br>';
echo gethostbyaddr('77.88.55.66') . '<br>';
echo gethostbyaddr('127.0.0.1') . '<br>';
echo '<pre>';
print_r(gethostbynamel('yandex.ru'));
print_r(gethostbynamel('ya.ru'));
print_r(gethostbynamel('test.r'));