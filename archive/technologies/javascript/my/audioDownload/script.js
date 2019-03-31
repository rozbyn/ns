
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


var jojj = ap.play;
ap.play = function () {
	console.log(arguments);
	return jojj.apply(this, arguments);
};
ap.on(null, AudioPlayer.EVENT_CURRENT_CHANGED, function () {console.log(arguments)});


window.ap._impl._currentHls.coreComponents[4].mediaSource;





// window.ap._ensureHasURL(audioArr, fun);
/****************************************************************************************************************/




function strToUint8Array(str, cb) {
	cb = cb || function(){};
	var blob = new Blob([str]);
	var filer = new FileReader;
	filer.addEventListener('loadend', function(e){
		var r = e.target.result;
		var view = new Uint8Array(r);
		cb(str, view);
	});
	filer.readAsArrayBuffer(blob);
}


function joinTwoTypedArray(arr1, arr2) {
	var buff = arr1.length + arr2.length;
	var newA = new Uint8Array(buff);
	newA.set(arr1);
	newA.set(arr2, arr1.length);
	return newA;
}

