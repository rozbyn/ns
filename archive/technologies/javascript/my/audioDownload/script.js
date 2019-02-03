
/* global ap, SourceBuffer */

let logElement = document.getElementsByClassName("ui_crumb")[0];
logElement.innerHTML = '';
function log(msg) {
  logElement.innerHTML += msg + "\n";
}
function wait(delayInMS) {
  return new Promise(resolve => setTimeout(resolve, delayInMS));
}
function startRecording(stream, lengthInMS) {
  let recorder = new MediaRecorder(stream);
  let data = [];
 
  recorder.ondataavailable = event => data.push(event.data);
  recorder.start();
  log(recorder.state + " for " + (lengthInMS/1000) + " seconds...");
 
  let stopped = new Promise((resolve, reject) => {
    recorder.onstop = resolve;
    recorder.onerror = event => reject(event.name);
  });

  let recorded = wait(lengthInMS).then(
    () => recorder.state == "recording" && recorder.stop()
  );
 
  return Promise.all([
    stopped,
    recorded
  ])
  .then(() => data);
}

function downloadBlob (r) {
	url = window.URL.createObjectURL(r);
	var a = document.createElement('a');
	a.href = url;
	a.download = 'sdasd.mp3';
	a.click();
}
ap._impl._audioNodes[0].currentTime = 0;
startRecording(ap._impl._audioNodes[0].captureStream(), ap._impl._audioNodes[0].duration*1000).then(downloadBlob);


function findKey(key, obj, currPath, arKeys){
	obj = obj || window;
	currPath = currPath || '->Window';
	arKeys = arKeys || [];
	if(typeof obj === 'object' && obj !== null){
		for(var i in obj){
			var newPath = currPath + '->' + i;
			if(i === key) {
				arKeys.push(newPath);
			}
			findKey(key, obj[i], newPath, arKeys);
		}
		return arKeys;
	} else {
		return false;
	}
}

var ip = {
	'a' : {
		'nn' : {
			'dd' : 1
		}
	},
	'b' : {
		'nn' : {
			'dd' : 1
		}
	},
	'v' : {
		'nn' : {
			'dd' : 1
		}
	},
	'c' : {
		'nn' : {
			'dd' : 1
		}
	}
};

findKey('c', ip);

window.ap._impl._currentHls.coreComponents[4].mediaSource;


var sourceBufStor = [];
var sourceArrStor = [];
origSBAppend = SourceBuffer.prototype.appendBuffer;
SourceBuffer.prototype.appendBuffer = function (source) {
	saveSB(this, source);
	return origSBAppend.apply(this, arguments);
};


function saveSB (sB, arBin) {
	var i = sourceBufStor.findIndex(function (el) {return el === sB;});
	if(i === -1){
		var arLen = sourceBufStor.push(sB);
		sourceArrStor[arLen-1] = [arBin];
		sB.addEventListener('updateend', checkEnded.bind(null, (arLen-1)));
	} else {
		sourceArrStor[i].push(arBin);
	}
}

function checkEnded(index, e) {
	if(e.target.ended){
		saveFile(index);
	}
}

function saveFile(index) {
	var filename = getCurrentAudioFilename();
	var file = new File(sourceArrStor[index], filename);
	var a = document.createElement('a');
	var d = URL.createObjectURL(file);
	a.download = filename;
	a.href = d;
	a.click();
}

function getCurrentAudioFilename() {
	if(window.ap && window.ap.getCurrentAudio){
		var a = window.ap.getCurrentAudio();
		if(a[3] !== '' && a[4] !== '' ){
			return a[4] + ' – ' + a[3] + '.mp3';
		}
	}
	return 'track.mp3';
}


// window.ap._ensureHasURL(audioArr, fun);
/****************************************************************************************************************/

