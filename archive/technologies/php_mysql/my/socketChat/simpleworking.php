<?php
function go(){
	$starttime = round(microtime(true),2);
	myEcho("GO() ... <br />\r\n");

	myEcho( "socket_create ...");
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

	if($socket < 0){
		myEcho( "Error: ".socket_strerror(socket_last_error())."<br />\r\n");
		exit();
	} else {
	    myEcho( "OK <br />\r\n");
	}
	

	myEcho ("socket_bind ...");
	$bind = socket_bind($socket, '127.0.0.1', 889);//привязываем его к указанным ip и порту
	if($bind < 0){
	    myEcho ("Error: ".socket_strerror(socket_last_error())."<br />\r\n");
		exit();
	}else{
	    myEcho( "OK <br />\r\n");
	}	
	
	socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);//разрешаем использовать один порт для нескольких соединений

	myEcho ("Listening socket... ");
	$listen = socket_listen($socket, 5);//слушаем сокет

	if($listen < 0){
	    myEcho ("Error: ".socket_strerror(socket_last_error())."<br />\r\n");
		exit();
	}else{
	    myEcho ("OK <br />\r\n");
	}
	socket_set_nonblock($socket);
	while(true){ //Бесконечный цикл ожидания подключений
		myEcho ("Waiting... ");
	    $accept = @socket_accept($socket); //Зависаем пока не получим ответа
	    if($accept === false){
	      myEcho( "Error: ".socket_strerror(socket_last_error())."<br />\r\n");
		    usleep(1000000);
				
				if( ( round(microtime(true),2) - $starttime) > 10) { 
					myEcho ("time = ".(round(microtime(true),2) - $starttime)); 
					myEcho ("return <br />\r\n"); 
					return $socket;
				}
				
				continue;
	    } else {
	        myEcho( "OK <br />\r\n");
	        myEcho( "Client \"".$accept."\" has connected<br />\r\n");
		}
//			echo "Client \"".$accept."\" says:<br /><pre style=\"border:1px solid;\">";
//			echo socket_read($accept,8000);
//			echo "</pre>";
			
	    $msg = "Hello, Client!";
	    myEcho ("Send to client \"".$msg."\"... ");
	    socket_write($accept, $msg);
	    myEcho ("OK <br />\r\n");
		


	}


}

error_reporting(E_ALL); //Выводим все ошибки и предупреждения
set_time_limit(0);		//Время выполнения скрипта не ограничено
ob_implicit_flush();	//Включаем вывод без буферизации 

$socket = go();			//Функция с бесконечным циклом, возвращает $socket по запросу выполненному по прошествии 100 секнуд. 

myEcho ("go() ended<br />\r\n");

if (isset($socket)){
    myEcho ("Closing connection... ");
	@socket_shutdown($socket);
    socket_close($socket);
    myEcho ("OK <br />\r\n");
}


function myEcho($str) {
	echo $str;
	flush();
	ob_flush();
	flush();
	ob_flush();
}
