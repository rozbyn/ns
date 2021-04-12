
var interval;

onmessage = function(e) {
	if(e.data.action === 'startInterval'){
		interval = setInterval(onIntervalTick, e.data.msec);
		postMessage({action: 'startIntervalSuccess'});
	} else  if (e.data.action === 'stopInterval'){
		clearInterval(interval);
		interval = null;
		postMessage({action: 'stopIntervalSuccess'});
	}
};

function onIntervalTick() {
	postMessage({action: 'onIntervalTick'});
}