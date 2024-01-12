

(function () {




//    frame = BX24.getScrollSize();
//    BX24.resizeWindow(frame.scrollWidth, 1200); /???????????????????????????????????????????????????????????
	var logAddListener = false;
	var logWaitStack = [];
	var logElID = 'LOG_DIV';
	function log () {
		var myArgs = arguments;
		var logEl = document.getElementById(logElID);
		if(!logEl && !logAddListener){
			logEl = document.createElement('div');
			logEl.style.position = 'absolute';
			logEl.style.top = '10px';
			logEl.style.left = '10px';
			logEl.style.padding = '10px';
			logEl.style.background = '#fff';
			logEl.style.whiteSpace = 'pre';

			logEl.addEventListener('click', function () {
				logEl.innerHTML = '';
			});

			logEl.id = logElID;
			logAddListener = true;
			if(document.readyState === "complete"){
				document.body.appendChild(logEl);
				log.apply(null, myArgs);
			} else {
				window.addEventListener('load', function () {
					document.body.appendChild(logEl);
					log.apply(null, myArgs);
				});
			}
		} else if (!logEl && logAddListener) {
			logWaitStack.push(arguments);
		} else {
			if(logWaitStack.length > 0){
				for(var i = 0; i < logWaitStack.length; i++) {
					display(logWaitStack[i], logEl);
				};
				logWaitStack = [];
			}
			display(arguments, logEl);
		}
	}


	function display(args, logEl) {
		for (var i in args) {
			if (typeof args[i] === 'object' && args[i] !== null && typeof args[i].nodeName !== 'string') {
				logEl.innerHTML += '\r\n';
				logEl.innerHTML += JSON.stringify(args[i], null, '\t');
				logEl.innerHTML += '\r\n';
			} else {
				logEl.innerHTML += args[i] + ', ';
			}
		}
		logEl.innerHTML += '\r\n';
	}
	window.log = log;
})();



(function () {
	var lastOrientation = false;
	var bob = false;
	function checkOrientation() {
		var currOrientation = (window.innerWidth - window.innerHeight) > 0 ? 'L' : 'P';
		if(lastOrientation === false){
			lastOrientation = currOrientation;
		}
		if(lastOrientation === currOrientation) return;
		if(bob) return;
		bob = true;
		setTimeout(function () {
			location.reload();
		}, 1);
	}
	window.onresize = checkOrientation;
	checkOrientation();
})();

