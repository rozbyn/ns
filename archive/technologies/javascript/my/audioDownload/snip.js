javascript:(function(){

	var sourceBufStor = [];
	var sourceArrStor = [];
	var audioStor = [];
	checkEnded();
	
	var origSBAppend = SourceBuffer.prototype.appendBuffer;
	SourceBuffer.prototype.appendBuffer = function (source) {
		saveSB(this, source);
		return origSBAppend.apply(this, arguments);
	};


	function saveSB (sB, arBin) {
		if(!window.ap._isPlaying) return;
		var i = sourceBufStor.findIndex(function (el) {return el === sB;});
		if(i === -1){
			var arLen = sourceBufStor.push(sB);
			sourceArrStor[arLen-1] = arBin;
			audioStor[arLen-1] = {
				name: getCurrentAudioFilename(),
				downloaded: false
			};
		} else {
			sourceArrStor[i] = joinTwoTypedArray(sourceArrStor[i], arBin);
		}
	}
	
	var checkEndedInterval = false;
	function checkEnded() {
		if(!checkEndedInterval){
			checkEndedInterval = setInterval(function () {
				sourceBufStor.forEach(function (el, index) {
					if(el.ended && audioStor[index] && !audioStor[index].downloaded){
						var filename = audioStor[index].name;
						audioStor[index].downloaded = true;
						saveFile(index, filename);
					}
				});
			}, 500);
		}
	}

	function saveFile(index, filename) {
		console.log('saveFile', index);
		filename = filename || getCurrentAudioFilename();
		var file = new File([sourceArrStor[index]], filename);
		var d = URL.createObjectURL(file);
		var a = document.createElement('a');
		a.style.display = 'none';
		document.body.appendChild(a);
		a.download = filename;
		a.href = d;
		a.click();
		document.body.removeChild(a);
	}

	function getCurrentAudioFilename() {
		console.log('getCurrentAudioFilename');
		if(window.ap && window.ap.getCurrentAudio){
			var a = window.ap.getCurrentAudio();
			if(a[3] && a[4]){
				return a[4] + ' – ' + a[3] + '.mp3';
			}
		}
		return 'track.mp3';
	}
	
	function joinTwoTypedArray(arr1, arr2) {
		var buff = arr1.length + arr2.length;
		var newA = new Uint8Array(buff);
		newA.set(arr1);
		newA.set(arr2, arr1.length);
		return newA;
	}
	
	window.saveVkAudio = {};
	window.saveVkAudio.sourceBufStor = sourceBufStor;
	window.saveVkAudio.sourceArrStor = sourceArrStor;
	window.saveVkAudio.audioStor = audioStor;
	window.saveVkAudio.getCurrentAudioFilename = getCurrentAudioFilename;
	window.saveVkAudio.saveFile = saveFile;
	
})();