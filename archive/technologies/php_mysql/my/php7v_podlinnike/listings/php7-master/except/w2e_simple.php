<?php ## Преобразование ошибок в исключения.
  require_once "PHP/Exceptionizer.php";
register_shutdown_function('fatal_error_handler');
set_error_handler('eror');
function eror (...$a) {
	//if (error_reporting() == 0) return false;
	echo '<div style="border: 2px solid; margin: 10px">';
	echo "Ошибочка!" . '<br>';
	echo "Код ошибочки: " . $a[0]. '<br>';
	echo "Файл: " . $a[2]. '<br>';
	echo "Строка: " . $a[3]. '<br>';
	echo "Текст ошибочки: " . $a[1]. '<br>';
	echo '</div>';
	return true;
}
function fatal_error_handler() {
	file_put_contents('E:\\\\adasd.txt',date('d.m.Y h:i:s') . ': hjhkhk'.PHP_EOL, FILE_APPEND);
	//var_dump(error_get_last());
    // если была ошибка и она фатальна
	
    if ($error = error_get_last() AND $error['type'] & ( E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)){
    //if ($error = error_get_last()){
        // очищаем буффер (не выводим стандартное сообщение об ошибке)
        $as = ob_get_clean();
        // запускаем обработчик ошибок
		
		echo $as;
        eror($error['type'], $error['message'], $error['file'], $error['line']);
    } else {
        // отправка (вывод) буфера и его отключение
        ob_end_flush();
    }
}
ob_start();

  // Для большей наглядности поместим основной проверочный код в функцию.
  //suffer();
$a = $oaushnda;
class c {function f(){}} c::f();
trigger_error("E_USER_NOTICE", E_USER_NOTICE);
trigger_error("E_USER_ERROR", E_USER_ERROR);
//undefined_function();
//class b {function f(int $a){}} $b = new b; $b->f(NULL);

//if()
//class b {function f(int $a){}} $b = new b; $b->f(NULL);

  // Убеждаемся, что перехват действительно был отключен.
  //echo "<b>Дальше должно идти обычное сообщение PHP.</b><br>";
  //fopen("fork", "r");
$asd = E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR;
$asd2 = 1 & $asd;
//echo $asd . '<br>';
$types = [
	"E_ERROR", "E_WARNING", "E_PARSE", "E_NOTICE", "E_CORE_ERROR",
	"E_CORE_WARNING", "E_COMPILE_ERROR", "E_COMPILE_WARNING",
	"E_USER_ERROR", "E_USER_WARNING", "E_USER_NOTICE", "E_STRICT",
	"E_RECOVERABLE_ERROR", "E_DEPRECATED", "E_USER_DEPRECATED",
	"E_ALL"
];

echo '<pre>';
foreach ($types as $err) {
	printf('%2$19s: %1$-5d %1$\'016b<br>', constant($err), $err);
}
echo '</pre>';

undefined_function();

  function suffer()
  {
    // Создаем новый объект-преобразователь. Начиная с этого момента 
    // и до уничтожения переменной $w2e все перехватываемые ошибки 
    // превращаются в одноименные исключения.
	
    $w2e = new PHP_Exceptionizer(E_ALL);
	//strlen();
	
    try {
      // Открываем несуществующий файл. Здесь будет ошибка E_WARNING.
      //fopen("spoon", "r");
	  strlen();
	  
    } catch (E_EXCEPTION $e) {
      // Перехватываем исключение класса E_WARNING.
      echo "<pre><b>Перехвачена ошибка!</b>\n", $e, "</pre>";
    }
    // В конце можно явно удалить преобразователь командой:
    // unset($w2e);
    // Но можно этого и не делать - переменная и так удалится при
    // выходе из функции (при этом вызовется деструктор объекта $w2e,
    // отключающий слежение за ошибками).
  }
//



?>