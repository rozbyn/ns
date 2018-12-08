<?php
//if(extension_loaded('sockets')) echo "WebSockets OK";
//else echo "WebSockets UNAVAILABLE";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Siple Web-Socket Client</title>
	</head>
	<body>

		Server address:<br>
		<input id="sock-addr" type="text" value="ws://127.0.0.1:8889">
		<input id="sock-conn-butt" type="button" value="connect">
		<input id="sock-disc-butt" type="button" value="disconnect"><br>
		Message:<br>
		<input id="sock-msg" type="text">

		<input id="sock-send-butt" type="button" value="send">
		<br>
		<br>
		
		<br>
		<br>

		Полученные сообщения от веб-сокета: 
		<div id="sock-info" style="border: 1px solid"> </div>
		<script src="script.js" type="text/javascript"></script>
	</body>
</html>