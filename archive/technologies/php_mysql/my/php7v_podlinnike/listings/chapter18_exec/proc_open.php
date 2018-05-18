<?php 
$descriptorspec = array(
   0 => array("pipe", "r"),  // stdin - канал, из которого дочерний процесс будет читать
   1 => array("pipe", "w"),  // stdout - канал, в который дочерний процесс будет записывать 
   2 => array("file", 'E:\\loggi.txt', "a") // stderr - файл для записи
);

$cwd = 'E:\install\php';
$env = array();

$process = proc_open('PHP', $descriptorspec, $pipes, $cwd, $env);

if (is_resource($process)) {
    // $pipes теперь выглядит так:
    // 0 => записывающий обработчик, подключенный к дочернему stdin
    // 1 => читающий обработчик, подключенный к дочернему stdout
    // Вывод сообщений об ошибках будет добавляться в /tmp/error-output.txt

    fwrite($pipes[0], '<?php print_r($_SERVER); ?>');
    // fwrite($pipes[0], 'CD');
    // fwrite($pipes[0], 'CD E:\rmz');
	// fwrite($pipes[0], 'CD');
    fclose($pipes[0]);
	echo 'Начало ответа----------------------' . '<pre>';
    echo stream_get_contents($pipes[1]);
	echo 'Конец ответа----------------------' . '</pre>';
    fclose($pipes[1]);

    // Важно закрывать все каналы перед вызовом
    // proc_close во избежание мертвой блокировки
    $return_value = proc_close($process);

    echo "команда вернула $return_value\n<br>";
}


$cwd = 'C:\\Windows\\System32\\';
$env = array();

$process = proc_open('ping localhost', $descriptorspec, $pipes, $cwd, $env);
$commands = [
	'open ftp.rozbyn.esy.es',
	'u784337761',
	'vWJG3oCVBK',
	'lcd E:\\',
	'get',
	'favicon.ico',
	'asdasdasda.ico',
	'close',
	'quit',
];
if (is_resource($process)) {
    // $pipes теперь выглядит так:
    // 0 => записывающий обработчик, подключенный к дочернему stdin
    // 1 => читающий обработчик, подключенный к дочернему stdout
    // Вывод сообщений об ошибках будет добавляться в /tmp/error-output.txt

    fwrite($pipes[0], 'ping ya.ru');
    // fwrite($pipes[0], 'CD');
    // fwrite($pipes[0], 'CD E:\rmz');
	// fwrite($pipes[0], 'CD');
    fclose($pipes[0]);
	echo 'Начало ответа----------------------' . '<pre>';
    echo iconv('IBM866', 'UTF-8', stream_get_contents($pipes[1]));
	echo 'Конец ответа----------------------' . '</pre>';
    fclose($pipes[1]);

    // Важно закрывать все каналы перед вызовом
    // proc_close во избежание мертвой блокировки
    $return_value = proc_close($process);

    echo "команда вернула $return_value\n";
}


