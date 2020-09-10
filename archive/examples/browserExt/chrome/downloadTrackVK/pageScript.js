
/* global saveVkAudioExtensionKey, SourceBuffer, chrome, contentScriptTabs, vk, saveVkAudioThisTabID, AdsLight, ap, URL */

;javascript:(function(){
	setInterval(function () {
		try {AdsLight.setNewBlock = function () {};} catch (e) {}
		try {ap._checkAdsPlay = function (a,b,cb) {if(typeof cb === 'function') {cb();}};} catch (e) {}
		try {ap.ads._fetchAd = function(e, t, n, o, i){if(typeof o === 'function') o();};} catch (e) {}
		var adsBlock = document.getElementById('ads_left');
		if (!adsBlock) return;
		if (adsBlock.style.display !== 'none') {
			adsBlock.style.display = 'none';
		}

	}, 1000);

	if(!saveVkAudioExtensionKey || !saveVkAudioThisTabID) return;
//	document.head.removeChild(document.getElementById('saveVkAudioScript2'));
	sendMessageToBackgroundScript('pageScriptReady', tracksInfo);
	var sourceBufStor = [];
	var sourceArrStor = [];
	var audioStor = [];
	var tracksInfo = {};
	var actionsHandlers = {
		"downloadTrack": function (request) {
			if(!request.data.id || !(request.data.id in tracksInfo)) return;
			var trInfo = tracksInfo[request.data.id];
			if(trInfo.status === 'directLink' && trInfo.directLink){
				saveFileByDirectUrl(trInfo);
			} else {
				trInfo.file = new File([sourceArrStor[trInfo.binArIndex]], trInfo.name);
				saveFile(trInfo.file);
			}
		}
	};
	checkEnded();
	
	var origSBAppend = SourceBuffer.prototype.appendBuffer;
	SourceBuffer.prototype.appendBuffer = function (source) {
		saveSB(this, source);
		return origSBAppend.apply(this, arguments);
	};


	function saveSB (sB, arBin) {
		if(!window.ap._isPlaying) return;
		var i = sourceBufStor.indexOf(sB);
		if(i === -1){
			var trackInfo = getCurrentTrackInfo();
			sB.trackID = trackInfo.id;
			trackInfo['soundBuffer'] = sB;
			trackInfo['status'] = 'loading';
			var arLen = sourceBufStor.push(sB);
			sourceArrStor[arLen-1] = arBin;
			trackInfo['binArIndex'] = arLen-1;
			tracksInfo[trackInfo.id] = trackInfo;
			sendTracksInfo();
		} else {
			sourceArrStor[i] = joinTwoTypedArray(sourceArrStor[i], arBin);
		}
	}
	
	var checkEndedInterval = false;
	function checkEnded() {
		if(!checkEndedInterval){
			checkEndedInterval = setInterval(function () {
				sourceBufStor.forEach(function (el) {
					if(el.ended && el.trackID && tracksInfo[el.trackID].status === 'loading'){
						var trInfo = tracksInfo[el.trackID];
						trInfo.status = 'ready';
//						trInfo.file = new File(sourceArrStor[trInfo.binArIndex], trInfo.name);
					}
				});
				sendTracksInfo();
			}, 500);
		}
	}
	
	
	function sendTracksInfo() {
		var objToSend = {};
		for(var i in tracksInfo){
			objToSend[i] = {
				name: tracksInfo[i].name,
				id: tracksInfo[i].id,
				tabID: tracksInfo[i].tabID,
				status: tracksInfo[i].status
			};
			if(tracksInfo[i].directLink){
				objToSend[i].directLink = tracksInfo[i];
			}
		}
		sendMessageToBackgroundScript('tracksInfo', objToSend);
	}
	
	
	
	function saveFile(file) {
		var d = URL.createObjectURL(file);
		var a = document.createElement('a');
		a.style.display = 'none';
		document.body.appendChild(a);
		a.download = file.name;
		a.href = d;
		a.click();
		document.body.removeChild(a);
	}

	function getCurrentAudioFilename() {
		if(window.ap && window.ap.getCurrentAudio){
			var a = window.ap.getCurrentAudio();
			if(a[3] && a[4]){
				return a[4] + ' - ' + a[3] + '.mp3';
			}
		}
		return 'track.mp3';
	}
	
	
	
	function saveFileByDirectUrl(trackInfo) {
		var a = document.createElement('a');
		a.style.display = 'none';
		document.body.appendChild(a);
		a.download = trackInfo.name;
		a.href = trackInfo.directLink;
		a.target = '_blank';
		a.click();
		document.body.removeChild(a);
	}
	
	
	
	function getCurrentTrackInfo() {
		var trackInfo = {};
		var a = window.ap.getCurrentAudio();
		trackInfo['id'] = a[1] + '_' + a[0];
		trackInfo['name'] = a[4] + ' - ' + a[3] + '.mp3';
		trackInfo['tabID'] = saveVkAudioThisTabID;
		return trackInfo;
	}
	
	
	
	function joinTwoTypedArray(arr1, arr2) {
		var buff = arr1.length + arr2.length;
		var newA = new Uint8Array(buff);
		newA.set(arr1);
		newA.set(arr2, arr1.length);
		return newA;
	}
	
	function sendMessage (data) {
		window.postMessage({extKey: saveVkAudioExtensionKey, data: data}, "*");
	}
	
	
	window.saveVkAudio = {};
	window.saveVkAudio.sourceBufStor = sourceBufStor;
	window.saveVkAudio.sourceArrStor = sourceArrStor;
	window.saveVkAudio.tracksInfo = tracksInfo;
	window.saveVkAudio.audioStor = audioStor;
	window.saveVkAudio.getCurrentAudioFilename = getCurrentAudioFilename;
	window.saveVkAudio.saveFile = saveFile;
	window.saveVkAudio.saveFileByDirectUrl = saveFileByDirectUrl;
	window.saveVkAudio.sendMessage = sendMessage;
	
	
	
	
	
	window.addEventListener("message", messagesHandler);
	
	function messagesHandler(ev) {
		if(!checkMessage(ev.data)) return;
		runActionHandler(ev.data);
	}
	
	
	function runActionHandler(request) {
		if (request.action in actionsHandlers) {
			return actionsHandlers[request.action](request);
		}
	}
	
	
	
	function checkMessage(request) {
		var isValid =
				request.target
				&& request.target === 'page'
				&& request.extKey
				&& request.extKey === saveVkAudioExtensionKey
				&& request.action;
		return isValid;
	}



	function sendMessageToContentScript(action, data, cb) {
		if (contentScriptTabs.length <= 0) return	cb(20000);
		data = data || {};
		var objToSend = {
			target: 'content',
			extKey: saveVkAudioExtensionKey,
			action: action,
			data: data
		};
		chrome.runtime.sendMessage(saveVkAudioExtensionKey, objToSend, cb);
	}



	function sendMessageToBackgroundScript(action, data, cb) {
		data = data || {};
		var objToSend = {
			target: 'background',
			extKey: saveVkAudioExtensionKey,
			action: action,
			data: data
		};
		chrome.runtime.sendMessage(saveVkAudioExtensionKey, objToSend, cb);
	}
	


	function sendMessageToPopupScript(action, data, cb) {
		data = data || {};
		var objToSend = {
			target: 'popup',
			extKey: saveVkAudioExtensionKey,
			action: action,
			data: data
		};
		chrome.runtime.sendMessage(saveVkAudioExtensionKey, objToSend, cb);
	}
	
	window.saveVkAudio.sendMessageToPopupScript = sendMessageToPopupScript;
	window.saveVkAudio.sendMessageToBackgroundScript = sendMessageToBackgroundScript;
	window.saveVkAudio.sendMessageToContentScript = sendMessageToContentScript;
	
	
	
	var directLinkRegex = /^https:\/\/.+?audios\/\w+\.(mp3|wav|wave|wma|ogg|aac|ac3)/;
	window.ap.eventBus.subscribe('start', async function () {
		var audioSrc = window.ap._impl._currentAudioEl.src;
		var isDirectLink = directLinkRegex.test(audioSrc);
		if(isDirectLink && !window.ap._impl._currentHls){ // Трек доступен по прямой ссылке
			var trackInfo = getCurrentTrackInfo();
			if(trackInfo.id in tracksInfo) return;
			var response = await fetch(audioSrc);
			var contentType = response.headers.get('content-type');
			if(response.status !== 200 || contentType.indexOf('audio') !== 0){
				return;
			}
			trackInfo.arrayBuffer = await response.arrayBuffer();
			trackInfo.binArIndex = sourceArrStor.length;
			sourceArrStor.push(trackInfo.arrayBuffer);
			trackInfo.status = 'ready';
//			trackInfo.directLink = audioSrc;
			tracksInfo[trackInfo.id] = trackInfo;
			
			
			
			sendTracksInfo();
		}
	});


/*
window.ap.eventBus.subscribe()
ADDED: "added"
AD_COMPLETED: "ad_completed"
AD_DEINITED: "ad_deinit"
AD_READY: "ad_ready"
AD_STARTED: "ad_started"
BUFFERED: "buffered"
CAN_PLAY: "actual_start"
CURRENT_CHANGED: "curr"
DESELECT: "deselect"
EMPTY_PLAYLIST: "empty_playlist"
ENDED: "ended"
FAILED: "failed"
FREQ_UPDATE: "freq"
INIT: "init"
LOADED: "loaded"
NOT_FOUND_PLAYLIST: "not_found_playlist"
PAUSE: "pause"
PLAY: "start"
PLAYLIST_CHANGED: "plchange"
PLAY_NEXT: "play_next"
PLAY_REQUESTED: "request_play"
PROGRESS: "progress"
REMOVED: "removed"
SEEK: "seek"
SELECT: "select"
START_LOADING: "start_load"
STOP: "stop"
UPDATE: "update"
VOLUME: "volume"

*/
	
})();