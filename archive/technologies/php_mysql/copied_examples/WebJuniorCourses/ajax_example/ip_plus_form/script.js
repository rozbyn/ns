window.onload = function (){
	document.querySelector('#shop_ip').onclick = function (){
		ajaxGet('show_ip.php');
		/* ajaxGet('ip.php', function (data){
			console.log(data);
		}); */
		
		/* ajaxGet('ip.php?id=12&a=b&hz=nz', function (data){
			document.querySelector('#myip').innerHTML = data;
		}); */
	}
	var inp_email = document.querySelector('input[name=email]');
	var inp_phone = document.querySelector('input[name=phone]');
	var inp_name = document.querySelector('input[name=name2]');

	document.querySelector('#send').onclick = function (){
		var params = 'email=' + inp_email.value + '&' + 'phone=' + inp_phone.value + '&' + 'name=' + inp_name.value;
		console.log(params);
		ajaxPost(params);
	}
}

function ajaxGet(url, callback){
	var request = new XMLHttpRequest();
	var f = callback || function(data){
		document.querySelector('#myip').innerHTML = data;
	};
	request.onreadystatechange = function(){
		if (request.readyState == 4 && request.status == 200){
			f(request.responseText);
		} else if (request.readyState == 1) {
			document.querySelector('#myip').innerHTML = 'Загрузка...';
		}
	}
	request.open('GET', url);
	request.send();
}
function ajaxPost(params){
	var request = new XMLHttpRequest();
	//var f = аа || function(){};
	request.onreadystatechange = function(){
		if (request.readyState == 4 && request.status == 200){
			if (request.responseText == '1'){
				document.querySelector('#result').innerHTML = 'Форма успешно отправлена!';
				document.querySelector('form').style.display = 'none';
			} else {
				document.querySelector('#result').innerHTML = request.responseText;
			}
		} 
	}
	request.open('POST', 'save_form.php');
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	request.send(params);
}