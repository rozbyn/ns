



function tickerClass() {
	var self = this;
	this.isRunning = false;
	this.listeners = [];
	this.intervalId = false;
	this.intervalMsec = 20;
	this.timesExecute = 0;
	this.autoStart = true;
	this.autoEnd = true;
	this.start = function () {
		self.intervalId = setInterval(function () {
			self.timesExecute++;
			self.listeners.forEach(function (func) {
				func(self);
			});
		}, self.intervalMsec);
	};
	this.stop = function () {
		clearInterval(self.intervalId);
		self.intervalId = false;
		self.timesExecute = 0;
	};
	this.addListener = function (func) {
		if (self.listeners.indexOf(func) === -1) {
			self.listeners.push(func);
			if (self.listeners.length === 1 && !self.isRunning && self.autoStart) {
				self.start();
			}
		}
	};
	this.removeListener = function (func) {
		var inx = self.listeners.indexOf(func);
		if (inx !== -1) {
			self.listeners.splice(inx, 1);
			if (self.listeners.length === 0 && self.isRunning && self.autoEnd) {
				self.stop();
			}
		}
	};
}
tickerClass.static = new tickerClass();
var ticker = new tickerClass();





function timer(params) {
	params = (typeof params === 'object' && params !== null) ? params : {};
	params.msec = params.msec > 100 ? params.msec : 1000; 
	params.onStart = (typeof params.onStart === 'function') ? params.onStart :function () {};
	params.onEnd = (typeof params.onEnd === 'function') ? params.onEnd :function () {};
	if (params.timerType === 'timeout') {
		params.timeID = setTimeout(function () {
			params.onEnd(params, 'onEnd');
		}, params.msec);
		params.onStart(params, 'onStart');
		return params.timeID;
	} else {
		var dateEnd = Date.now() + params.msec;
		var tickerFunc = function () {
			if (dateEnd <= Date.now()) {
				ticker.removeListener(tickerFunc);
				params.onEnd(params, 'onEnd');
			}
		};
		ticker.addListener(tickerFunc);
		params.onStart(params, 'onStart');
	}
}







function timersArray(timers) {
	if (typeof timers !== 'object' || timers === null || !timers.length) {
		throw new Error('first parameter must be array');
	}
	var self = this;
	this.timers = timers;
	this.currIndex = 0;
	this.currTimer = timers[0];
	var onCurrTimerEnds = function(params, evName) {
		self.currIndex++;
		self.currTimer = timers[self.currIndex];
		if (typeof self.currTimer === 'object' && self.currTimer !== null) {
			startCurrTimer();
		}
	};
	var startCurrTimer = function() {
		if (typeof self.currTimer.onEnd === 'function') {
			var origOnEnd = self.currTimer.onEnd;
			self.currTimer.onEnd = function (params, evName) {
				self.currTimer.onEnd = origOnEnd;
				origOnEnd(params, evName);
				onCurrTimerEnds(params, evName);
			};
		} else {
			self.currTimer.onEnd = function (params, evName) {
				onCurrTimerEnds(params, evName);
				delete self.currTimer.onEnd;
			};
		}
		timer(self.currTimer);
	};
	this.startTimers = function () {
		startCurrTimer();
	};
	
	
	
}


function requestPermission() {
  return new Promise(function(resolve, reject) {
    const permissionResult = window.Notification.requestPermission(function(result) {
      // Поддержка устаревшей версии с функцией обратного вызова.
      resolve(result);
    });

    if (permissionResult) {
      permissionResult.then(resolve, reject);
    }
  })
  .then(function(permissionResult) {
    if (permissionResult !== 'granted') {
      throw new Error('Permission not granted.');
    }
  });
}



function subscribeUserToPush() {
  return navigator.serviceWorker.register('service-worker.js')
  .then(function(registration) {
    var subscribeOptions = {
      userVisibleOnly: true,
      applicationServerKey: base64UrlToUint8Array(
        'BKT5kerifUq3Ewadkppnf_UNwHW7QyHUkLLCllFEPIup8mvCs_kGHrcdF6ZhcHG87nZxqRVLAQsQzqz8qG_bSlo'
      )
    };

    return registration.pushManager.subscribe(subscribeOptions);
  })
  .then(function(pushSubscription) {
    console.log('PushSubscription: ', JSON.stringify(pushSubscription));
    return pushSubscription;
  });
}






function base64UrlToUint8Array(base64UrlData) {
    const padding = '='.repeat((4 - base64UrlData.length % 4) % 4);
    const base64 = (base64UrlData + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = atob(base64);
    const buffer = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        buffer[i] = rawData.charCodeAt(i);
    }

    return buffer;
}

//requestPermission();
//subscribeUserToPush();

/*

{
"subject": "mailto: <ezcs@yandex.ru>",
"publicKey": "BKT5kerifUq3Ewadkppnf_UNwHW7QyHUkLLCllFEPIup8mvCs_kGHrcdF6ZhcHG87nZxqRVLAQsQzqz8qG_bSlo",
"privateKey": "L3JSt1jyPJLFBYPU2nDVIVrkM_Ld6YpS2YqdvqsBByA"
}


{
  "endpoint": "https://fcm.googleapis.com/fcm/send/e_FkgKxCSFI:APA91bEPq07hpmIJj1sTC1KFmqYlDT0HepmMrKC2WXgKvtktz4FTZk40E1b-ccTjqBLJzGEKmKcV4AY5uCTh7oHh8d1sj76rycB032Pv4QE96xbLnUKBpbPCx2nsfGZmU4WaDjcC4Tf5",
  "expirationTime": null,
  "keys": {
    "p256dh": "BEwAog1P0s_Lvejcv64r8EpsAM1nXX2wu5gMGsfPcOauxujFOtTP11HED08UeXhjy1Mk9GpQt_UTq-DakKcYesQ",
    "auth": "dMEA3aTYKK5PzAh-c61_og"
  }
}

https://web-push-codelab.glitch.me/

 */




//var e1, e2;
//
//var evHandler = function (params, evName) {
//	console.log(evName, params.msec);
//};
//var bob = new timersArray([
//	{msec: 500, onStart: evHandler, onEnd: evHandler},
//	{msec: 600, onStart: evHandler, onEnd: evHandler},
//	{msec: 700, onStart: evHandler, onEnd: evHandler},
//	{msec: 600, onStart: evHandler, onEnd: evHandler},
//	{msec: 500, onStart: evHandler, onEnd: evHandler},
//	{msec: 400, onStart: evHandler, onEnd: evHandler},
//	{msec: 300, onStart: evHandler, onEnd: evHandler},
//	{msec: 200, onStart: evHandler, onEnd: evHandler},
//]);
//
//bob.startTimers();


self.registration.showNotification('title', {
	actions: [
		{action: 'like', title: '👍Like', icon: 'data:image/png;base64,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'},
		{action: 'reply', title: '⤻ Reply', icon: 'https://s1.iconbird.com/ico/1012/EcommerceBusinessIcons/w256h2561350823232print256x256.png'},
	],
	badge: 'https://s1.iconbird.com/ico/1012/EcommerceBusinessIcons/w256h2561350823232print256x256.png'
});
