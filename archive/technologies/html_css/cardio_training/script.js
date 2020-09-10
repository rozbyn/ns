/* global sounds, labels */

function Timer(target, action, interval, repeat) {
	var timerIsRunning = false;
	var t, cycle, fire;
	fire = function () {
		target[action].call(target);
		if (repeat === true) {
			cycle();
		}
	};
	cycle = function () {
		if (timerIsRunning) {
			t = setTimeout(function () {
				fire();
			}, interval);
		}
	};
	this.start = function () {
		timerIsRunning = true;
		fire();
	};
	this.stop = function () {
		clearTimeout(t);
		timerIsRunning = false;
	};
}

function STTabataTimer(delegate) {
	this.sessionPhases = {
		start: 0,
		prepare: 1,
		work: 2,
		rest: 3,
		end: 4
	};
	this.isRunning = false;
	this.timer = new Timer(this, "fireTimer", 1000, true);
	this.preparationTimeSetting = 45;
	this.workTimeSetting = 30;
	this.restTimeSetting = 15;
	this.cyclesSetting = 4;
	this.tabatasSetting = 6;
	this.sessionPhase = this.sessionPhases.start;
	this.currentTabata = 1;
	this.currentTime = 0;
	this.totalTime = 0;
	this.currentCycle = 1;
	this.start = function () {
		if (this.isRunning) {
			return;
		}
		if (this.sessionPhase === this.sessionPhases.start) {
			this.sessionPhase = this.calculateNextPhase();
		}
		if (this.sessionPhase !== this.sessionPhases.end) {
			this.isRunning = true;
			this.timer.start();
		} else {
			this.endSession();
		}
	};
	this.stop = function () {
		if (this.isRunning) {
			this.timer.stop();
			this.isRunning = false;
		}
	};
	this.reset = function () {
		this.stop();
		this.currentTime = 0;
		this.totalTime = 0;
		this.currentCycle = 1;
		this.currentTabata = 1;
		this.sessionPhase = this.sessionPhases.start;
	};
	this.calculateNextPhase = function () {
		switch (this.sessionPhase) {
			case this.sessionPhases.start:
				if (this.preparationTimeSetting > 0) {
					this.sessionPhase = this.sessionPhases.prepare;
				} else if (this.workTimeSetting > 0) {
					this.sessionPhase = this.sessionPhases.work;
				} else if (this.restTimeSetting > 0) {
					this.sessionPhase = this.sessionPhases.rest;
				} else {
					this.sessionPhase = this.sessionPhases.end;
				}
				break;
			case this.sessionPhases.prepare:
				if (this.workTimeSetting > 0) {
					this.sessionPhase = this.sessionPhases.work;
				} else if (this.restTimeSetting > 0) {
					this.sessionPhase = this.sessionPhases.rest;
				} else if (this.currentTabata < this.tabatasSetting) {
					this.currentTabata++;
					delegate['tabataComplete'].call(this);
					this.currentCycle = 1;
				} else {
					this.sessionPhase = this.sessionPhases.end;
				}
				break;
			case this.sessionPhases.work:
				if (this.restTimeSetting > 0) {
					this.sessionPhase = this.sessionPhases.rest;
				} else if (this.currentCycle < this.cyclesSetting) {
					this.currentCycle++;
				} else if (this.currentTabata < this.tabatasSetting) {
					this.currentTabata++;
					delegate['tabataComplete'].call(this);
					this.currentCycle = 1;
					if (this.preparationTimeSetting > 0) {
						this.sessionPhase = this.sessionPhases.prepare;
					} else {
						this.sessionPhase = this.sessionPhases.work;
					}
				} else {
					this.sessionPhase = this.sessionPhases.end;
				}
				break;
			case this.sessionPhases.rest:
				if (this.currentCycle < this.cyclesSetting) {
					this.currentCycle++;
					if (this.workTimeSetting > 0) {
						this.sessionPhase = this.sessionPhases.work;
					}
				} else if (this.currentTabata < this.tabatasSetting) {
					this.currentTabata++;
					delegate['tabataComplete'].call(this);
					this.currentCycle = 1;
					if (this.preparationTimeSetting > 0) {
						this.sessionPhase = this.sessionPhases.prepare;
					} else if (this.workTimeSetting > 0) {
						this.sessionPhase = this.sessionPhases.work;
					} else if (this.restTimeSetting > 0) {
						this.sessionPhase = this.sessionPhases.rest;
					} else {
						this.sessionPhase = this.sessionPhases.end;
					}
				} else {
					this.sessionPhase = this.sessionPhases.end;
				}
				break;
		}
		if (this.sessionPhase === this.sessionPhases.prepare) {
			this.currentTime = this.preparationTimeSetting;
		} else if (this.sessionPhase === this.sessionPhases.work) {
			this.currentTime = this.workTimeSetting;
		} else if (this.sessionPhase === this.sessionPhases.rest) {
			this.currentTime = this.restTimeSetting;
		}
		return this.sessionPhase;
	};
	this.endSession = function () {
		this.reset();
		delegate['sessionEnded'].call(this);
	};
	this.fireTimer = function () {
		if (this.currentTime === 0) {
			if (this.calculateNextPhase() === this.sessionPhases.end) {
				this.endSession();
			}
		}
		delegate['timerHasFired'].call(this);
		this.totalTime++;
		this.currentTime--;
	};
}

function STTabataTimerViewController() {
	var field = 'prepare';
	var playSound;
	var stopSound;
	var changeTimerData;
	var totalWorkoutTime;
	var convertDouble;
	var convertTimeFormat;
	var changeLayoutState;
	var t, s;
	var intervals = 300;
	var tabatatimer = new STTabataTimer(this);
	var isPaused = false;
	this.stopped = false;
	this.setField = function (f) {
		field = f;
		if (field === 'prepare') {
			document.getElementById('arrow').style.top = "34px";
		} else if (field === 'work') {
			document.getElementById('arrow').style.top = "98px";
		} else if (field === 'rest') {
			document.getElementById('arrow').style.top = "162px";
		} else if (field === 'cycles') {
			document.getElementById('arrow').style.top = "226px";
		} else if (field === 'tabatas') {
			document.getElementById('arrow').style.top = "290px";
		}
	};
	
	var lastPlayedAudio;
	playSound = function (soundfile) {
		stopSound();
		console.log(soundfile, soundfile+'Audio');
		var audioEl = document.getElementById(soundfile+'Audio');
		if(!audioEl) return;
		lastPlayedAudio = audioEl;
		audioEl.currentTime = 0;
		var t = audioEl.play();
		
		
		t.then(function () {
//			log(1); 
		}, function () {
//			log(audioEl.error);
		});
//		document.getElementById('tt_sound').innerHTML = "<audio id=\"background_audio\" autoplay=\"autoplay\"><source src=\"" + soundfile + "\" type=\"audio/mpeg\" /></audio>";
	};
	stopSound = function () {
		if(lastPlayedAudio) lastPlayedAudio.pause();
	};
	setTimerData = function (i) {
		if (field === 'prepare') {
			tabatatimer.preparationTimeSetting += i;
			tabatatimer.preparationTimeSetting = Math.min(Math.max(tabatatimer.preparationTimeSetting, 0), 3599);
		} else if (field === 'work') {
			tabatatimer.workTimeSetting += i;
			tabatatimer.workTimeSetting = Math.min(Math.max(tabatatimer.workTimeSetting, 0), 3599);
		} else if (field === 'rest') {
			tabatatimer.restTimeSetting += i;
			tabatatimer.restTimeSetting = Math.min(Math.max(tabatatimer.restTimeSetting, 0), 3599);
		} else if (field === 'cycles') {
			tabatatimer.cyclesSetting += i;
			tabatatimer.cyclesSetting = Math.min(Math.max(tabatatimer.cyclesSetting, 1), 99);
		} else if (field === 'tabatas') {
			tabatatimer.tabatasSetting += i;
			tabatatimer.tabatasSetting = Math.min(Math.max(tabatatimer.tabatasSetting, 1), 99);
		}
		i = (intervals <= 100) ? (i > 0 ? 7 : -7) : i;
		i = (intervals === 20) ? (i > 0 ? 13 : -13) : i;
		t = setTimeout(function () {
			setTimerData(i);
		}, intervals);
		intervals = (intervals > 20) ? (intervals - 20) : intervals;
		changeLayoutState();
	};
	this.plus = function () {
		setTimerData(1);
	};
	this.minus = function () {
		setTimerData(-1);
	};
	this.invalidate = function () {
		clearTimeout(t);
		intervals = 300;
	};
	this.zero = function () {
		if (field === 'prepare') {
			tabatatimer.preparationTimeSetting = 10;
		} else if (field === 'work') {
			tabatatimer.workTimeSetting = 20;
		} else if (field === 'rest') {
			tabatatimer.restTimeSetting = 10;
		} else if (field === 'cycles') {
			tabatatimer.cyclesSetting = 8;
		} else if (field === 'tabatas') {
			tabatatimer.tabatasSetting = 1;
		}
		changeLayoutState();
	};
	totalWorkoutTime = function () {
		var cycle = (tabatatimer.workTimeSetting + tabatatimer.restTimeSetting);
		var tabata = (cycle * tabatatimer.cyclesSetting) + tabatatimer.preparationTimeSetting;
		return (tabata * tabatatimer.tabatasSetting);
	};
	convertDouble = function (num) {
		return (num < 10 ? "0" + num : num);
	};
	convertTimeFormat = function (num) {
		var hrs = Math.floor(num / 3600);
		var mins = Math.floor((num % 3600) / 60);
		var secs = num % 60;
		return (hrs > 0 ? hrs + ":" : "") + (mins < 10 ? "0" : "") + mins + ":" + (secs < 10 ? "0" : "") + secs;
	};
	changeLayoutState = function () {
		switch (parseInt(tabatatimer.sessionPhase)) {
			case 1:
				document.getElementById('currenttime').innerHTML = convertTimeFormat(tabatatimer.currentTime);
				document.getElementById('tt_clock_label').innerHTML = labels.prepare;
				document.getElementById('tt_clock_wrap').className = "tt_clock_prepare";
				if (tabatatimer.currentTime < 4 && tabatatimer.currentTime > 0) {
					if (tabatatimer.preparationTimeSetting > 4) {
						playSound('' + sounds.warning);
					}
				}
				break;
			case 2:
				document.getElementById('currenttime').innerHTML = convertTimeFormat(tabatatimer.currentTime);
				document.getElementById('tt_clock_label').innerHTML = labels.work;
				document.getElementById('tt_clock_wrap').className = "tt_clock_work";
				if (tabatatimer.currentTime < 4 && tabatatimer.currentTime > 0) {
					if (tabatatimer.preparationTimeSetting > 4) {
						playSound('' + sounds.warning);
					}
				}
				if (tabatatimer.workTimeSetting === tabatatimer.currentTime) {
					playSound('' + sounds.work);
				}
				break;
			case 3:
				document.getElementById('currenttime').innerHTML = convertTimeFormat(tabatatimer.currentTime);
				document.getElementById('tt_clock_label').innerHTML = labels.rest;
				document.getElementById('tt_clock_wrap').className = "tt_clock_rest";
				if (tabatatimer.currentTime < 4 && tabatatimer.currentTime > 0) {
					if (tabatatimer.preparationTimeSetting > 4) {
						playSound('' + sounds.warning);
					}
				}
				if (tabatatimer.restTimeSetting === tabatatimer.currentTime) {
					playSound('' + sounds.rest);
				}
				break;
			default:
				document.getElementById('currenttime').innerHTML = convertTimeFormat(totalWorkoutTime());
				if (totalWorkoutTime() > 3600) {
					document.getElementById('currenttime').style.fontSize = "145px";
				}
				if (totalWorkoutTime() > 36000) {
					document.getElementById('currenttime').style.fontSize = "120px";
				}
				if (totalWorkoutTime() > 3600000) {
					document.getElementById('currenttime').style.fontSize = "100px";
				}
				document.getElementById('tt_clock_wrap').className = "tt_clock_default";
				document.getElementById('tt_clock_label').innerHTML = labels.workout;
				break;
		}
		document.getElementById('currentcycle').innerHTML = convertDouble(tabatatimer.cyclesSetting - tabatatimer.currentCycle + 1);
		document.getElementById('currenttabata').innerHTML = convertDouble(tabatatimer.tabatasSetting - tabatatimer.currentTabata + 1);
		document.getElementById('setpreparetime').value = convertTimeFormat(tabatatimer.preparationTimeSetting);
		document.getElementById('setworktime').value = convertTimeFormat(tabatatimer.workTimeSetting);
		document.getElementById('setresttime').value = convertTimeFormat(tabatatimer.restTimeSetting);
		document.getElementById('setcycles').value = convertDouble(tabatatimer.cyclesSetting - tabatatimer.currentCycle + 1);
		document.getElementById('settabatas').value = convertDouble(tabatatimer.tabatasSetting - tabatatimer.currentTabata + 1);
	};
	this.sessionLoaded = function () {
		document.getElementById('setpreparetime_label').innerHTML = labels.prepare;
		document.getElementById('setworktime_label').innerHTML = labels.work;
		document.getElementById('setresttime_label').innerHTML = labels.rest;
		document.getElementById('setcycles_label').innerHTML = labels.cyclesl;
		document.getElementById('settabatas_label').innerHTML = labels.tabatasl;
		document.getElementById('startbutton').innerHTML = labels.start;
		document.getElementById('resetbutton').innerHTML = labels.stop;
		document.getElementById('pausebutton').innerHTML = labels.pause;
		document.getElementById('tt_clock_label').innerHTML = labels.workout;
		document.getElementById('tt_cycles_label').innerHTML = labels.cycles;
		document.getElementById('tt_tabatas_label').innerHTML = labels.tabatas;
		changeLayoutState();
	};
	this.timerHasFired = function () {
		document.getElementById('currentcycle').innerHTML = convertDouble(tabatatimer.cyclesSetting - tabatatimer.currentCycle + 1);
		document.getElementById('currenttabata').innerHTML = convertDouble(tabatatimer.tabatasSetting - tabatatimer.currentTabata + 1);
		changeLayoutState();
	};
	this.sessionEnded = function () {
		if (!this.stopped) {
			playSound('' + sounds.sessioncomplete);
		}
		document.getElementById('currentcycle').innerHTML = convertDouble(tabatatimer.cyclesSetting);
		document.getElementById('currenttabata').innerHTML = convertDouble(tabatatimer.tabatasSetting);
		document.getElementById('controls').style.display = "block";
		document.getElementById('startbutton').style.display = "block";
		document.getElementById('pausebutton').style.display = "none";
		document.getElementById('resetbutton').style.display = "none";
		changeLayoutState();
	};
	this.tabataComplete = function () {
		playSound('' + sounds.tabatacomplete);
		console.log('tabata complete');
	};
	this.startButtonPushed = function () {
		if (totalWorkoutTime() > 0) {
			tabatatimer.start();
			playSound('' + sounds.startingsession);
			document.getElementById('controls').style.display = "none";
			document.getElementById('startbutton').style.display = "none";
			document.getElementById('arrow').style.display = "none";
			document.getElementById('pausebutton').style.display = "block";
			document.getElementById('resetbutton').style.display = "block";
		}
	};
	this.stopButtonPushed = function () {
		if (!isPaused) {
			tabatatimer.stop();
			playSound('' + sounds.pausingsession);
			document.getElementById('pausebutton').className = "tt_big_button_selected";
			document.getElementById('pausebutton').innerHTML = labels.resume;
			isPaused = true;
		} else {
			tabatatimer.start();
			playSound('' + sounds.startingsession);
			document.getElementById('pausebutton').className = "tt_big_button";
			document.getElementById('pausebutton').innerHTML = labels.pause;
			isPaused = false;
		}
	};
	this.resetButtonPushed = function () {
		if (isPaused) {
			document.getElementById('pausebutton').className = "tt_big_button";
			document.getElementById('pausebutton').innerHTML = labels.pause;
		}
		document.getElementById('arrow').style.display = "block";
		tabatatimer.endSession();
		this.stopped = true;
		playSound('' + sounds.stoppingsession);
	};
}




























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