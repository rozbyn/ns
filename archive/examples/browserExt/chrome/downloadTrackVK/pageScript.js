
/* global saveVkAudioExtensionKey, SourceBuffer, chrome, contentScriptTabs, vk, saveVkAudioThisTabID, AdsLight, ap, URL, audio, playerAdapter */




;javascript:(function(){
	
	var thisScriptEl = document.getElementById('saveVkAudioScript');
	if (!thisScriptEl) return;
	var saveVkAudioExtensionKey = thisScriptEl.getAttribute('saveVkAudioExtensionKey');
	var saveVkAudioThisTabID = thisScriptEl.getAttribute('saveVkAudioThisTabID');
	if(!saveVkAudioExtensionKey || !saveVkAudioThisTabID) return;
	thisScriptEl.removeAttribute('saveVkAudioExtensionKey');
	thisScriptEl.removeAttribute('saveVkAudioThisTabID');
	
	
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
	
	var CAN_WORK = false;
	var IS_MOBILE_PLAYER = false;
	var sourceBufStor = [];
	var sourceArrStor = [];
	var audioStor = [];
	var tracksInfo = {};
//	sendMessageToBackgroundScript('pageScriptReady', tracksInfo);
	
	
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
		},
		"getTracksInfo" : function (request) {
			sendTracksInfo();
		}
	};
	checkEnded();
	
	var origSBAppend = SourceBuffer.prototype.appendBuffer;
	SourceBuffer.prototype.appendBuffer = function (source) {
//		console.log(this, this.ended, source);
		saveSB(this, source);
		return origSBAppend.apply(this, arguments);
	};


	function saveSB (sB, arBin) {
		if(
				!checkAudioPlayer()
				|| (!IS_MOBILE_PLAYER && !window.ap._isPlaying)
				|| (IS_MOBILE_PLAYER && !window.audio.isPlaying())
		){
			return;
		}
		var i = sourceBufStor.indexOf(sB);
		if(i === -1){
			var trackInfo = getCurrentTrackInfo();
			if(trackInfo.id in tracksInfo){
				trackInfo = getNextTrackInfo();
				if(!trackInfo) return;
//				console.log('DANGER!');
			}
			sB.trackID = trackInfo.id;
			trackInfo['soundBuffer'] = sB;
			trackInfo['status'] = 'loading';
			var arLen = sourceBufStor.push(sB);
			sourceArrStor[arLen-1] = arBin;
			trackInfo['binArIndex'] = arLen-1;
			tracksInfo[trackInfo.id] = trackInfo;
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
				sendTracksInfo('background');
			}, 500);
		}
	}
	
	
	function sendTracksInfo(target) {
		var objToSend = {};
		for(var i in tracksInfo){
			objToSend[i] = {
				name: tracksInfo[i].name,
				id: tracksInfo[i].id,
				tabID: tracksInfo[i].tabID,
				status: tracksInfo[i].status
			};
			if(tracksInfo[i].directLink){
				objToSend[i].directLink = tracksInfo[i].directLink;
			}
			if(tracksInfo[i].coverUrl){
				objToSend[i].coverUrl = tracksInfo[i].coverUrl;
			}
		}
		if (target === 'background') {
			sendMessageToBackgroundScript('tracksInfo', objToSend);
		} else {
			sendMessageToPopupScript('tracksInfo', objToSend);
		}
	}
	
	
	
	function saveFile(file) {
		var d = URL.createObjectURL(file);
		var a = document.createElement('a');
		a.style.display = 'none';
		document.body.appendChild(a);
		a.download = htmlDecode(file.name);
		a.href = d;
		a.click();
		URL.revokeObjectURL(d);
		document.body.removeChild(a);
	}
	
	
	
	
	function htmlDecode(text) {
		var e = document.createElement('textarea');
		e.innerHTML = text;
		return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
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
		if(!('ap' in window) && ('audio' in window) && ('audioplayer' in window)){
			var a = window.audio.getCurrent();
			trackInfo['id'] = a.fullId; // 5675103_456239174
			trackInfo['name'] = a.performer + ' - ' + a.title + '.mp3';
			if(typeof a.coverUrl_p === 'string' && a.coverUrl_p.length > 0){
				trackInfo.coverUrl = a.coverUrl_p;
			} else if(typeof a.coverUrl_s === 'string' && a.coverUrl_s.length > 0){
				trackInfo.coverUrl = a.coverUrl_s;
			}
		} else if ('ap' in window) {
			a = window.ap.getCurrentAudio();
			trackInfo['id'] = a[1] + '_' + a[0]; // 5675103_456239140
			trackInfo['name'] = a[4] + ' - ' + a[3] + '.mp3'; // Hatom - Hard Street (Исполнитель - Трек)
			var coverUrl = getCoverMaxSizeUrl(a[14]);
			if(coverUrl) trackInfo.coverUrl = coverUrl;
		}
		trackInfo['tabID'] = saveVkAudioThisTabID;
		return trackInfo;
	}
	
	
	
	function getCoverMaxSizeUrl(coverUrlsString) {
		if (typeof coverUrlsString !== 'string' || coverUrlsString.length < 1) {
			return false;
		}
		var url = false;
		var size = 0;
		var arUrls = coverUrlsString.split(',');
		for (var i = 0; i < arUrls.length; i++) {
			try {
				var urlObj = new URL(arUrls[i]);
			} catch (e) {
				continue;
			}
			var tempSize = parseInt(urlObj.searchParams.get('size'));
			if(isFinite(tempSize) && tempSize > 0 && tempSize > size){
				size = tempSize;
				url = arUrls[i];
			}
		}
		if(url) return url;
		return false;
	}
	
	
	
	function getNextTrackInfo() {
		var trackInfo = {};
		if(!('ap' in window) && ('audio' in window) && ('audioplayer' in window)){
			var a = window.audio.getCurrent();
			var playlistArray = window.audio.playlist();
			var nextAudio = false;
			for (var i = 0; i < playlistArray.length; i++) {
				if(playlistArray[i].fullId === a.fullId && playlistArray[i+1]){
					nextAudio = playlistArray[i+1];
					break;
				}
			}
			if(!nextAudio) return false;
			trackInfo.id = nextAudio.fullId; // 5675103_456239174
			trackInfo.name = nextAudio.performer + ' - ' + nextAudio.title + '.mp3';
			if(typeof nextAudio.coverUrl_p === 'string' && nextAudio.coverUrl_p.length > 0){
				trackInfo.coverUrl = nextAudio.coverUrl_p;
			} else if(typeof nextAudio.coverUrl_s === 'string' && nextAudio.coverUrl_s.length > 0){
				trackInfo.coverUrl = nextAudio.coverUrl_s;
			}
			
			
		} else if ('ap' in window) {
			a = window.ap.getCurrentPlaylist().getNextAudio(window.ap.getCurrentAudio());
			trackInfo.id = a[1] + '_' + a[0];
			trackInfo.name = a[4] + ' - ' + a[3] + '.mp3';
			var coverUrl = getCoverMaxSizeUrl(a[14]);
			if(coverUrl) trackInfo.coverUrl = coverUrl;
		}
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
	
	
	
	function onToggleAudioMessagePlay(elem) {
		var audioMessInfo = {
			id : elem.getAttribute('id'),
			name : elem.getAttribute('aria-label'),
			duration : elem.getAttribute('data-duration'),
			mp3link : elem.getAttribute('data-mp3'),
			ogglink : elem.getAttribute('data-ogg'),
		};
		if(audioMessInfo.id in tracksInfo) {
			origToggleAudioMessageFunc.apply(this, arguments);
			return;
		}
		var trackInfo = {};
		trackInfo.id = audioMessInfo.id;
		trackInfo.name = audioMessInfo.id + '.mp3';
		trackInfo.tabID = saveVkAudioThisTabID;
		trackInfo.status = 'loading';
		getArrayBufferByUrl(audioMessInfo.mp3link).then(function (buff) {
			if(!buff) return;
			trackInfo.arrayBuffer = buff;
			trackInfo.binArIndex = sourceArrStor.length;
			sourceArrStor.push(trackInfo.arrayBuffer);
			trackInfo.status = 'ready';
			sendTracksInfo('background');
		});
		tracksInfo[trackInfo.id] = trackInfo;
		origToggleAudioMessageFunc.apply(this, arguments);
	}
	
	
	window.saveVkAudio = {};
	window.saveVkAudio.sourceBufStor = sourceBufStor;
	window.saveVkAudio.sourceArrStor = sourceArrStor;
	window.saveVkAudio.tracksInfo = tracksInfo;
	window.saveVkAudio.audioStor = audioStor;
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
	
	
	
	function checkAudioPlayer() {
		if('ap' in window){
			IS_MOBILE_PLAYER = false;
			CAN_WORK = true;
		} else if (('audio' in window) && ('audioplayer' in window)) {
			IS_MOBILE_PLAYER = true;
			CAN_WORK = true;
		} else {
			CAN_WORK = false;
		}
		return CAN_WORK;
	}
	
	window.saveVkAudio.sendMessageToPopupScript = sendMessageToPopupScript;
	window.saveVkAudio.sendMessageToBackgroundScript = sendMessageToBackgroundScript;
	window.saveVkAudio.sendMessageToContentScript = sendMessageToContentScript;
	
	checkAudioPlayer();
	
	
	// playerAdapter
//	console.log(checkAudioPlayer() && !IS_MOBILE_PLAYER);
	if(checkAudioPlayer() && !IS_MOBILE_PLAYER){
		window.ap.eventBus.subscribe('start', async function () {
			var directLinkRegex = /^https:\/\/.+?\.(mp3|wav|wave|wma|ogg|aac|ac3)/;
			var audioSrc = window.ap._impl._currentAudioEl.src;
			var isDirectLink = directLinkRegex.test(audioSrc);
			if(isDirectLink && !window.ap._impl._currentHls){ // Трек доступен по прямой ссылке
				var trackInfo = getCurrentTrackInfo();
				if(trackInfo.id in tracksInfo) return;
				var buff = await getArrayBufferByUrl(audioSrc);
				if(!buff) return;
				trackInfo.arrayBuffer = buff;
				trackInfo.binArIndex = sourceArrStor.length;
				sourceArrStor.push(trackInfo.arrayBuffer);
				trackInfo.status = 'ready';
	//			trackInfo.directLink = audioSrc;
				tracksInfo[trackInfo.id] = trackInfo;
				sendTracksInfo('background');
			}
		});
	} else if (checkAudioPlayer() && IS_MOBILE_PLAYER && ('playerAdapter' in window)){
		playerAdapter.listenPlay(async function (trackID) {
			var directLinkRegex = /^https:\/\/.+?\.(mp3|wav|wave|wma|ogg|aac|ac3)/;
			var vkTrackInfo = playerAdapter.getAudio();
			var trackUrl = vkTrackInfo.url;
			var decodedUrl = decodeTrackUrl(trackUrl);
			if(
					!directLinkRegex.test(decodedUrl) 
					|| decodedUrl.indexOf('https://m.vk.com/mp3/audio_api_unavailable.mp3') === 0
					|| (trackID in tracksInfo)
			){
				return;
			}
			var trackInfo = getCurrentTrackInfo();
			var buff = await getArrayBufferByUrl(decodedUrl);
			if(!buff) return;
			trackInfo.arrayBuffer = buff;
			trackInfo.binArIndex = sourceArrStor.length;
			sourceArrStor.push(trackInfo.arrayBuffer);
			trackInfo.status = 'ready';
			tracksInfo[trackInfo.id] = trackInfo;
			sendTracksInfo('background');
		});
	}
	
	// AudioMessagePlayer.togglePlay
	
	var origToggleAudioMessageFunc;
	if(
			('AudioMessagePlayer' in window)
			&& ('togglePlay' in window.AudioMessagePlayer) 
			&& (typeof window.AudioMessagePlayer.togglePlay === 'function') 
	){
		origToggleAudioMessageFunc = window.AudioMessagePlayer.togglePlay;
		window.AudioMessagePlayer.togglePlay = onToggleAudioMessagePlay;
	}



	async function getArrayBufferByUrl(url) {
		var response = await fetch(url);
		var contentType = response.headers.get('content-type');
		if(response.status !== 200 || contentType.indexOf('audio') !== 0){
			return false;
		}
		return await response.arrayBuffer();
	}

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
	
	function decodeTrackUrl(e) {
		var On = {
				v: function(e) {
						return e.split("").reverse().join("");
				},
				r: function(e, t) {
						var n;
						e = e.split("");
						for (var i = kn + kn, a = e.length; a--; )
								~(n = i.indexOf(e[a])) && (e[a] = i.substr(n - t, 1));
						return e.join("");
				},
				s: function(e, t) {
						var n = e.length;
						if (n) {
								var i = function(e, t) {
										var n = e.length
											, i = [];
										if (n) {
												var a = n;
												for (t = Math.abs(t); a--; )
														t = (n * (a + 1) ^ t + a) % n,
														i[a] = t;
										}
										return i;
								}(e, t)
									, a = 0;
								for (e = e.split(""); ++a < n; )
										e[a] = e.splice(i[n - 1 - a], 1, e[a])[0];
								e = e.join("");
						}
						return e;
				},
				i: function(e, t) {
						return On.s(e, t ^ vk.id);
				},
				x: function(e, t) {
						var n = [];
						return t = t.charCodeAt(0),
						each(e.split(""), (function(e, i) {
								n.push(String.fromCharCode(i.charCodeAt(0) ^ t));
						}
						)),
						n.join("");
				}
		};
		
		var kn = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN0PQRSTUVWXYZO123456789+/=';
		function jn(e) {
			if (!e || e.length % 4 == 1) return !1;
			for (var t, n, i = 0, a = 0, o = ""; (n = e.charAt(a++)); )
				~(n = kn.indexOf(n)) && (t = i % 4 ? 64 * t + n : n,
						i++ % 4) && (o += String.fromCharCode(255 & t >> (-2 * i & 6)));
			return o;
		}
		
		if ((!window.wbopen || !~(window.open + "").indexOf("wbopen")) && ~e.indexOf("audio_api_unavailable")) {
			var t, n, i = e.split("?extra=")[1].split("#"), a = "" === i[1] ? "" : jn(i[1]);
			if ((i = jn(i[0])), "string" != typeof a || !i) return e;

			for (var o = (a = a ? a.split(String.fromCharCode(9)) : []).length; o--; ) {
				if ((t = ((n = a[o].split(String.fromCharCode(11)))).splice(0, 1, i)[0],!On[t])) return e;
				i = On[t].apply(null, n);
			}
			if (i && "http" === i.substr(0, 4)) return i;
		}
		return e;
	}
	
	
	window.decodeTrackUrl = decodeTrackUrl;
	
	
})();