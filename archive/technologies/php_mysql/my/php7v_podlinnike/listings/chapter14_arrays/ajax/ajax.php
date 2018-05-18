<?php
if(isset($_REQUEST['name123'])){
	if(!empty($_REQUEST['name123'])){
		die(", {$_REQUEST['name123']}!");
	} else {
		echo ', ANONYMOUS!';
	}
} else {
?>


<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AJAX</title>
</head>
<body>
	<pre id="hello">Helo!</pre>
	<form action="" method="POST">
		<input type="text" name="name" id="name123">
		<button id="submit" type="submit">Send</button>
		<button id="clear" type="reset">Clear</button>
	</form>
	<div id="debug"></div>
	<script>
		
		sendData = (e) => {
			e.preventDefault();
			var request = new XMLHttpRequest();
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){
					hello.innerHTML = hello.innerHTML.slice(0,-1) + request.responseText;
				}
			}
			request.open('POST', '');
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			request.send('name123='+encodeURIComponent(name123.value));
			debug.innerHTML = encodeURIComponent(name123.value);
		}
		submit.onclick = sendData;
		clear.onclick = () => {hello.innerHTML = 'Helo!';debug.innerHTML = '';};
	</script>
</body>
</html>
<?php } ?>