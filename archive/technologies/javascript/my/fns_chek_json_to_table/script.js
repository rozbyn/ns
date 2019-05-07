
document.addEventListener("DOMContentLoaded", ready);
var fileInput, chekItemsCont;





function ready() {
	fileInput = document.getElementById('file_input');
	chekItemsCont = document.getElementById('chek_items_container');
	fileInput.addEventListener("change", readFile, false);
	
}
function readFile() {
	if(this.files.length <= 0) return;
	var file = this.files[0];
	var reader = new FileReader;
	reader.addEventListener('loadend', function () {
		try {
			var temp1 = JSON.parse(reader.result);
		} catch (e) {}
		if(typeof temp1 === 'object'){
			renderTable(temp1);
		}
	});
	reader.readAsText(file);
}



function renderTable(obj) {
	if(
			'items' in obj
			&& 'length' in obj['items']
			&& obj['items']['length'] > 0
	){
		chekItemsCont.innerHTML = '';
		obj['items'].forEach(function (el) {
			chekItemsCont.appendChild(getChekItemEl(el));
		});
	}
}


function getChekItemEl(itemInfo) {
	var tr = document.createElement('tr');
	var td1 = document.createElement('td');
	var td2 = document.createElement('td');
	var td3 = document.createElement('td');
	var td4 = document.createElement('td');
	tr.appendChild(td1);
	tr.appendChild(td2);
	tr.appendChild(td3);
	tr.appendChild(td4);
	td1.innerHTML = itemInfo.name;
	td2.innerHTML = ((itemInfo.price / 100) + '').replace('.', ',');
	td3.innerHTML = itemInfo.quantity;
	td4.innerHTML = ((itemInfo.sum / 100) + '').replace('.', ',');
	return tr;
}
