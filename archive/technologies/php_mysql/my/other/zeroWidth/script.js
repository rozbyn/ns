

hiddenText
coverText
onPos
hide
textWithHidden



unhideText
unhide
unHiddenText


debug
sendDataToEncode = () => {
	let params =	'encodeText=true&textToHide=' +
					encodeURIComponent(hiddenText.value) +
					'&textForCover=' + 
					encodeURIComponent(coverText.value) + 
					'&onPosition=' +
					encodeURIComponent(onPos.value);
	
	let catchAjaxAnswer = (data, node) => {
		textWithHidden.value = data;
	};
	ajaxPost('', params, this, catchAjaxAnswer);
};

sendDataToDecode = () => {
	let params =	"decodeText=true&unhideText=" + unhideText.value;
	let catchAjaxAnswer = (data, node) => {
		unHiddenText.value = data;
	};
	ajaxPost('', params, this, catchAjaxAnswer);
};


hide.addEventListener("click", sendDataToEncode);

unhide.addEventListener("click", sendDataToDecode);











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
	};
	request.open('GET', url);
	request.send();
}


function ajaxPost(url, params, node, callback){
	
	var request = new XMLHttpRequest();
    var f = callback || function(data){} ;
	request.onreadystatechange = function(){
		if (request.readyState == 4 && request.status == 200){
			
            f(request.responseText, node);
			
		} 
	};
	request.open('POST', url);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	request.send(params);
}





/*
multipart/form-data
application/x-www-form-urlencoded
text-plain
*/













