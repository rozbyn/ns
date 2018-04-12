<?php
	if (isset($_POST['sended'])) {
		exit($_POST['text']);
	}
?>

<!DOCTYPE html> 
<html>
    <head>
        <title>test</title>
        <meta charset="UTF-8">
    </head>
    <body>
		<input id="text"><br>
		<textarea id="resul"></textarea><br>
		<button id="sendText">send</button><br>
	<script type="text/javascript" src="script.js"></script>
    </body>
</html>