




folders = document.getElementsByClassName('expl_folder');
parentFolders = document.getElementsByClassName('par_folder');

window.onload = addEventFolders(folders);
window.onload = addEventParentFolders(parentFolders);



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
		} 
	};
	request.open('POST', url);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	request.send(params);
}