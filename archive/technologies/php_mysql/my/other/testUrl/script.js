function send () {
	encText = encodeURIComponent(text.value);
	
	let params = 'sended=1&text=' + encText;
	let url = '';
	let request = new XMLHttpRequest();
	request.onreadystatechange = function(){
		if (request.readyState == 4 && request.status == 200){
			resul.value = request.responseText;
		}
	}
	request.open('POST', url);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	request.send(params);
}

sendText.addEventListener("click", send);