
function renderBarcode(debugInfo, element) {
  element.innerHTML = '<div style="position: relative; height: 100%"></div>';
	var cont = element.firstElementChild;
	var totalLines = 10;
	var halfLines = totalLines / 2;
	for (var i = 0; i < totalLines; i++) {
		var line = document.createElement('div');
		line.style.position = 'absolute';
		line.style.top = '0px';
		line.style.height = '100%';
		var rightPos = (i >= halfLines);
		var nmbr = rightPos ? i - halfLines : i;
		var rem = nmbr % 2;
		var quo = Math.floor(nmbr / 2);
		var coords = (rem * 4) + (quo * 9);
		if (rem === 1) {
			line.style.width = '5px';
			line.style.backgroundColor = '#ffffff';
		} else {
			line.style.width = '4px';
			line.style.backgroundColor = '#000000';
		}
		if (rightPos) {
			line.style.right = coords + 'px';
		} else {
			line.style.left = coords + 'px';
		}
		cont.appendChild(line);
		
	}
	var bitElementsArr = [];
	for (var k = 0; k < 384; k++) {
		var bitEl = document.createElement('div');
		bitEl.style.position = 'absolute';
		bitEl.style.width = '8px';
		bitEl.style.height = '8px';
		bitEl.style.top = (Math.floor(k / 32) * 8)+'px';
		bitEl.style.left = (22 + ((k % 32) * 8))+'px';
		cont.appendChild(bitEl);
		bitElementsArr.push(bitEl);
	}
	var paintByte = function (number, byteIndex) {
		var binary = number.toString(2);
		binary = '0'.repeat(8-binary.length) + binary;
		for (var i = 0; i < 8; i++) {
			var bitElementIndex = (byteIndex * 8) + i;
			var bitEl = bitElementsArr[bitElementIndex];
			bitEl.style.backgroundColor = binary[i] === '1' ? '#000000' : '#ffffff';
		}
	};
	
	debugInfo.code = debugInfo.code + '';
	debugInfo.code = '0'.repeat(3 - debugInfo.code.length) + debugInfo.code;
	debugInfo.message = debugInfo.message + ' '.repeat(34 - debugInfo.message.length);
	var targetString = debugInfo.id + debugInfo.code + debugInfo.message;
	var controlSumm = 0;
	targetString.split('').forEach(function (el, idx) {
		var num = el.charCodeAt(0);
		controlSumm = controlSumm ^ num;
		paintByte(num, idx);
		
	});
	paintByte(controlSumm, targetString.length);
	
}

var debugInfo = {  
     "id": "ezeb2fve0b",  
     "code": '10',  
     "message": "404 Error coffee not found"  
};

var el = document.getElementById('barcode');

renderBarcode(debugInfo, el);