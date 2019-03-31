(function () {
	var dropZone = document.getElementById('dropZone');
	var fileElem = document.getElementById('fileElem');
	var textEl = dropZone.getElementsByClassName('wrap3')[0];
	var lastText = textEl.innerText;
	var isLoading = false;
	
	
	fileElem.addEventListener('change', fileElChanged);
	dropZone.addEventListener('click', function () {
		if(isLoading) return;
		fileElem.click();
	});
	dropZone.addEventListener("dragenter", dragover);
	dropZone.addEventListener("dragover", dragover);
	dropZone.addEventListener("dragend", dragEnd);
	dropZone.addEventListener("dragexit", dragEnd);
	dropZone.addEventListener("drop", dragEnd);
	dropZone.addEventListener("drop", drop);
	
	function dragover(e) {
		if(isLoading) return;
		e.stopPropagation();
		e.preventDefault();
		dropZone.classList.add('dragover');
	}
	function dragEnd(e) {
		if(isLoading) return;
		e.stopPropagation();
		e.preventDefault();
		dropZone.classList.remove('dragover');
	}
	function drop(e) {
		if(isLoading) return;
		isLoading = true;
		toggleLoading();		
		e.stopPropagation();
		e.preventDefault();
		var dt = e.dataTransfer;
		var files = dt.files;
		var file = files[0];
		processFile(file);
	}
	function fileElChanged() {
		if(isLoading) return;
		isLoading = true;
		toggleLoading();
		var files = fileElem.files;
		var file = files[0];
		processFile(file);
	}
	
	
	var loadingInterval = false;
	function toggleLoading() {
		if(loadingInterval) {
			clearInterval(loadingInterval);
			textEl.innerText = lastText;
			dropZone.classList.remove('loading');
		} else {
			dropZone.classList.add('loading');
			loadingInterval = setInterval(function () {
				if(textEl.innerText === lastText || textEl.innerText.length > 5){
					textEl.innerText = '.';
				} else {
					textEl.innerText += '.';
				}
			}, 200);
		}
	}
	
	
	function processFile(file) {
		var reader = new FileReader;
		reader.addEventListener('loadend', function () {
			processArrayBuffer(reader.result);
		});
		reader.readAsArrayBuffer(file);
	}
	
	function processArrayBuffer(arrayBuff) {
		var ar = new Uint8Array(arrayBuff);
		var splittedAr = splitUint8Array(ar);
		var fileName = 'tempFile';
		var newFile = new File(splittedAr, fileName);
		saveFile(newFile, fileName);
		isLoading = false;
		toggleLoading();
	}
	
	
	function splitUint8Array(Uint8ArrayA) {
		var partSize = Math.floor(Math.sqrt(Uint8ArrayA.length));
		var lastPartSize = Uint8ArrayA.length % partSize;
		var returnAr = [];
		for (var start = 0, end = partSize; end < Uint8ArrayA.length;) {
			var t = Uint8ArrayA.slice(start, end);
			returnAr.push(t);
			start += partSize;
			end += partSize;
		}
		if(lastPartSize > 0){
			t = Uint8ArrayA.slice(start, (start + lastPartSize));
			returnAr.push(t);
		}
		return returnAr;
	}
	
	function saveFile(file, filename) {
		var d = URL.createObjectURL(file);
		var a = document.createElement('a');
		a.style.display = 'none';
		document.body.appendChild(a);
		a.download = filename;
		a.href = d;
		a.click();
		document.body.removeChild(a);
	}
	
})();