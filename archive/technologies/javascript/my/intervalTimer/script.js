
/* global z_util */



function BaseTimer(config) {
	if(undefined === this.timerSec) this.timerSec = z_util.getParam(config, 'timerSec', 0);
	if(undefined === this.onStartCB) this.onStartCB = z_util.getParam(config, 'onStartCB', z_util.doNothing);
	if(undefined === this.onTickCB) this.onTickCB = z_util.getParam(config, 'onTickCB', z_util.doNothing);
	if(undefined === this.onEndCB) this.onEndCB = z_util.getParam(config, 'onEndCB', z_util.doNothing);
	if(undefined === this.checkIntervalMs) this.checkIntervalMs = z_util.getParam(config, 'checkIntervalMs', 200);
	if(undefined === this.checkIntervalType) this.checkIntervalType = z_util.getParam(
			config, 
			'checkIntervalType', 
			window.Worker && CheckIntervalWorker ? 'worker' : 'interval'
	);
	
	this.startTimeTS = 0;
	this.endTimeTS = 0;
	this.isRunning = false;
	this.isEnded = false;
	this.endOffset = 0;
	this.checkInterval = false;
	
}




BaseTimer.prototype.checkEnded = function () {
	if(this.isRunning){
		return this.getCurrentTimeTs() >= this.endTimeTS;
	}
	return this.isEnded;
};



BaseTimer.prototype.getCurrentTimeTs = function () {
	return Date.now() / 1000;
};



BaseTimer.prototype.start = function () {
	if(this.isEnded) throw new Error("Timer already ended");
	if(this.isRunning) throw new Error("Timer already running");
	var sec = parseFloat(this.timerSec);
	if(!isFinite(sec) || !(sec > 0)){
		throw new Error("Parameter timerSec must be positive integer");
	}
	this.startTimeTS = this.getCurrentTimeTs();
	this.endTimeTS = this.startTimeTS + sec;
	this.isRunning = true;
	this.isEnded = false;
	if(typeof this.onStartCB === 'function') this.onStartCB(this);
	if(this.checkIntervalType === 'interval'){
		this.startTimerEndInterval();
	} else if (this.checkIntervalType === 'worker'){
		this.timerEndIntervalFuncBinded = this.timerEndIntervalFunc.bind(this);
		CheckIntervalWorker.addTickCallbacks(this.timerEndIntervalFuncBinded);
	}
};



BaseTimer.prototype.setEnded = function () {
	this.isRunning = false;
	this.isEnded = true;
	if(this.checkIntervalType === 'interval'){
		clearInterval(this.checkInterval);
	} else if (this.checkIntervalType === 'worker'){
		CheckIntervalWorker.removeTickCallbacks(this.timerEndIntervalFuncBinded);
	}
	this.endOffset = this.getCurrentTimeTs() - this.endTimeTS;
	if(typeof this.onEndCB === 'function') this.onEndCB(this, this.endOffset);
};




BaseTimer.prototype.startTimerEndInterval = function () {
	if(!this.checkInterval){
		this.checkInterval = setInterval(this.timerEndIntervalFunc.bind(this), this.checkIntervalMs);
	}
};



BaseTimer.prototype.timerEndIntervalFunc = function () {
	if(!this.checkEnded()){
		if(typeof this.onTickCB === 'function') this.onTickCB(this);
		return;
	} 
	this.setEnded();
};






function CheckIntervalWorkerClass(msec) {
	var self = this;
	this.tickCallbacks = [];
	
	this.msec = 10;
	if(msec && isFinite(parseInt(msec)) && parseInt(msec) > 0){
		this.msec = parseInt(msec);
	}
	
	
	
	this.workerObj = null;
	this.workerIntervalStarted = false;
	
	
	
	this.initWorker = function () {
		if(!this.workerObj){
			this.workerObj = new Worker("js/workerTimer.js");
			this.workerObj.onmessage = this.onWorkerIncomingMessage;
		}
	};
	
	
	
	this.startWorkerInterval = function () {
		this.workerObj.postMessage({action:'startInterval', msec: this.msec});
	};
	
	
	
	this.stopWorkerInterval = function () {
		this.workerObj.postMessage({action:'stopInterval'});
	};
	
	
	
	this.onWorkerIncomingMessage = function (e) {
		if(e.data.action === 'onIntervalTick'){
			self.callTickCallbacks();
		} else if (e.data.action === 'startIntervalSuccess'){
			console.log('worker startIntervalSuccess');
			self.workerIntervalStarted = true;
		} else if (e.data.action === 'stopIntervalSuccess'){
			console.log('worker endIntervalSuccess');
			self.workerIntervalStarted = false;
		}
	};
	
	
	
	this.addTickCallbacks = function (cb) {
		if(!this.workerIntervalStarted){
			this.startWorkerInterval();
		}
		this.tickCallbacks.push(cb);
	};
	
	
	
	this.removeTickCallbacks = function (cb) {
		var indx = this.tickCallbacks.indexOf(cb);
		if(indx === -1) return;
		this.tickCallbacks.splice(indx, 1);
		if(this.tickCallbacks.length === 0){
			this.stopWorkerInterval();
		}
	};
	
	
	
	this.callTickCallbacks = function () {
		for (var i = 0; i < this.tickCallbacks.length; i++) {
			this.tickCallbacks[i]();
		}
	};
	
	
	
	
	this.initWorker();
	
}


window.CheckIntervalWorker = new CheckIntervalWorkerClass();


var startTs = Date.now() / 1000;
var timer1 = new BaseTimer({
	timerSec: 10,
	onStartCB: function (timer) {
		console.log('onStartCb', this, Date.now() / 1000 - startTs);
	},
	onTickCB: function (timer) {
		console.log('onTickCB', this, Date.now() / 1000 - startTs);
	},
	onEndCB: function (timer, endOffset) {
		console.log('onEndCB', this, Date.now() / 1000 - startTs, endOffset);
	},
	checkIntervalMs: 300,
});

timer1.start();