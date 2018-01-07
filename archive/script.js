




folders = document.getElementsByClassName('expl_folder');
parentFolders = document.getElementsByClassName('par_folder');

window.onload = addEventFolders(folders, 'expl_folder');
window.onload = addEventParentFolders(parentFolders, 'par_folder');



function addEventParentFolders (htmlCollect){
    var len = htmlCollect.length;
    for(var i=0;i<len;i++){
        htmlCollect[i].addEventListener("click", function () {
            var params = 'path='+this.firstChild.value;
            ajaxPost('explorer.php', params, this, function (data, s) {
                var p = s.parentNode.parentNode;
                p.innerHTML = data;
                var folders = p.getElementsByClassName('expl_folder');
                var parentFolders = p.getElementsByClassName('par_folder');
                addEventFolders(folders);
                addEventParentFolders(parentFolders);
            });
        })
    }
}


function addEventFolders(htmlCollect) {
    /*
    parFolders = document.getElementsByClassName('par_folder');
    parFoldersLen = parFolders.length;
    for(var i=0;i<parFoldersLen;i++){
        parFolders[i].addEventListener("click", function () {
            alert("parFolders: "+this.innerHTML);
        })
    }
*/



/*
    curFolders = document.getElementsByClassName('curr_folder');
    curFoldLen = curFolders.length;
    for(var i=0;i<curFoldLen;i++){
        curFolders[i].addEventListener("click", function () {
            alert("curFolder: "+this.innerHTML);
        })
    }
*/
    /*
     files = document.getElementsByClassName('expl_file');
     filLen = files.length;
     for(var i=0;i<filLen;i++){
     files[i].addEventListener("click", function () {
     alert("file: "+this.innerHTML);
     })
     }
*/

    //folders = document.getElementsByClassName('expl_folder');
    var len = htmlCollect.length;
    for(var i=0;i<len;i++){
        htmlCollect[i].addEventListener("click", function () {
            var params = 'path='+this.firstChild.value;
            ajaxPost('explorer.php', params, this, function (data, s) {
                var p = s.parentNode;
                p.innerHTML = data;
                var folders = p.getElementsByClassName('expl_folder');
                var parentFolders = p.getElementsByClassName('par_folder');
                addEventFolders(folders);
                addEventParentFolders(parentFolders);
            });
        })
    }
}




/*

window.onload = function (){
	document.querySelector('#shop_ip').onclick = function (){
		ajaxGet('show_ip.php');
		/* ajaxGet('ip.php', function (data){
			console.log(data);
		}); */
		
		/* ajaxGet('ip.php?id=12&a=b&hz=nz', function (data){
			document.querySelector('#myip').innerHTML = data;
		});
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
*/
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
function ajaxPost(url, params, s, callback){
	var request = new XMLHttpRequest();
    var f = callback || function(data){} ;
	request.onreadystatechange = function(){
		if (request.readyState == 4 && request.status == 200){
            f(request.responseText, s);

			//alert(request.responseText);


            /*
            if (request.responseText == '1'){
				document.querySelector('#result').innerHTML = 'Форма успешно отправлена!';
				document.querySelector('form').style.display = 'none';
			} else {
				document.querySelector('#result').innerHTML = request.responseText;
			}
			*/
		} 
	};
	request.open('POST', url);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	request.send(params);
}