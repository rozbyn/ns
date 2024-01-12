
/* global chrome */


var contentScriptTabs = [];
var extKey = chrome.runtime.id;
var actionsHandlers = {
	"tracksInfo": function (request, sender, sendResponse) {
		jo.processTracksInfo(request.data);
	}
};

var currentTabID;

chrome.windows.getCurrent().then(function (result) {
	return result.id;
}).then(function (windowID) {
	return chrome.tabs.query({active: true, windowId: windowID});
}).then(function (tabs) {
	if (!tabs || tabs.length !== 1 || !tabs[0].id) return;
	currentTabID = tabs[0].id;
	sendMessageToPageScript(currentTabID, 'getTracksInfo');
	setInterval(function () {
		sendMessageToPageScript(currentTabID, 'getTracksInfo');
	}, 500);
});




var jo = new popupWindowHandler;


//sendMessageToBackgroundScript('getTracksInfo', 0 , processTracksInfo);




















/*----------------------------------------------------------------------------*/
var checkReadyInterval = false;
var updateInfoTimeout = false;
var wasFirstChecked = false;
function processTracksInfo(newTracksInfo) {
	if(newTracksInfo === false){
		if(!wasFirstChecked) jo.showHelp();
		if(!checkReadyInterval){
			checkReadyInterval = setInterval(function () {
				sendMessageToBackgroundScript('getTracksInfo', 0 , processTracksInfo);
			}, 200);
		}
	} else {
		if(!wasFirstChecked) jo.hideHelp();
		sendMessageToBackgroundScript('getContentScriptTabs', 0 , function (taabs) {
			contentScriptTabs = taabs;
		});
		clearInterval(checkReadyInterval);
		jo.processTracksInfo(newTracksInfo);
		updateInfoTimeout = setTimeout(function () {
			sendMessageToBackgroundScript('getTracksInfo', 0 , processTracksInfo);
			sendMessageToBackgroundScript('getContentScriptTabs', 0, function (taabs) {
				contentScriptTabs = taabs;
			});
		}, 1000);
	}
	wasFirstChecked = true;
}



chrome.runtime.onMessage.addListener(messagesHandler);
chrome.runtime.onMessageExternal.addListener(messagesHandler);



function messagesHandler(request, sender, sendResponse) {
	if(!checkMessage(request, sender)) return;
	runActionHandler(request, sender, sendResponse);
}



function runActionHandler(request, sender, sendResponse) {
	if(request.action in actionsHandlers){
		return actionsHandlers[request.action](request, sender, sendResponse);
	} else {
		sendResponse(10000);
	}
}



function checkMessage(request, sender) {
	var isValid = 
			sender.tab.id === currentTabID
			&& request.target
			&& request.target === 'popup'
			&& request.extKey
			&& request.extKey === extKey
			&& request.action;
	return isValid;
}



//function sendMessageToContentScript(tabID, action, data, cb) {
//	data = data || {};
//	if(contentScriptTabs.length <= 0) return (20000);
//	var objToSend = {
//		target: 'content',
//		extKey: extKey,
//		action: action,
//		data: data
//	};
//	if(tabID && contentScriptTabs.indexOf(tabID) !== -1){
//		chrome.tabs.sendMessage(tabID, objToSend, cb);
//	} else if (tabID === 'all') {
//		contentScriptTabs.forEach(function (y_tabID) {
//			chrome.tabs.sendMessage(y_tabID, objToSend, cb);
//		});
//	}
//}



function sendMessageToPageScript(tabID, action, data) {
	tabID = parseInt(tabID);
	data = data || {};
	var objToSend = {
		target: 'content',
		extKey: extKey,
		action: 'messageToPage',
		pageAction: action,
		data: data
	};
	chrome.tabs.sendMessage(tabID, objToSend);
}



function sendMessageToBackgroundScript(action, data, cb) {
	data = data || {};
	var objToSend = {
		target: 'background',
		extKey: extKey,
		action: action,
		data: data
	};
	chrome.runtime.sendMessage(objToSend, cb);
}


function popupWindowHandler() {
	var tracksInfo = this.tracksInfo = {};
	var trackStatusAli = {
		"ready": 'Готов к загрузке',
		"loading": 'Загружается...',
	};
	
	var htmlVars = {
		'helpContainer': {'type': 'id', 'selector': 'helpContainer'},
		'showHelpLabel': {'type': 'id', 'selector': 'showHelpLabel'},
		'tracksTableBody': {'type': 'id', 'selector': 'tracksTableBody'}
	};
	setHtmlVars();
	addListeners();
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	this.processTracksInfo = processTracksInfo;
	function processTracksInfo(newTracksInfo) {
		if(!isTracksChanged(newTracksInfo)) return;
		tracksInfo = newTracksInfo;
		renderTracks();
	}
	
	
	
	this.hideHelp = function () {
		htmlVars.helpContainer.classList.add('collapsed');
	};
	this.showHelp = function () {
		htmlVars.helpContainer.classList.remove('collapsed');
	};
	
	
	
	function addListeners() {
		
		htmlVars.showHelpLabel.addEventListener('click', function () {
			htmlVars.helpContainer.classList.toggle('collapsed');
		});
		
	}
	
	
	
	function isTracksChanged(newTracksInfo) {
		if(isObjEmpty(tracksInfo) && isObjEmpty(newTracksInfo)) return false;
		for (var i in newTracksInfo) {
			if(i in tracksInfo){
				if(
						newTracksInfo[i].id !== tracksInfo[i].id
						|| newTracksInfo[i].name !== tracksInfo[i].name
						|| newTracksInfo[i].status !== tracksInfo[i].status
						|| newTracksInfo[i].tabID !== tracksInfo[i].tabID
				){
					return true;
				}
			} else {
				return true;
			}
		}
		return false;
	}
	
	
	
	
	function renderTracks() {
		htmlVars.tracksTableBody.innerHTML = '';
		for(var i in tracksInfo){
			var trTempl = getTrackTemplate(tracksInfo[i]);
			htmlVars.tracksTableBody.appendChild(trTempl.cont);
		}
	}
	
	
	function getTrackTemplate(trackInfo) {
		var cont = document.createElement('tr');
		if(trackInfo.status === 'ready'){
			cont.classList.add("readyToDownload");
		}
		var nameRowEl = document.createElement('td');
		var actionsRowEl = getActionsTemplate(trackInfo).cont;
		if(trackInfo.coverUrl){
			var coverLink = document.createElement('a');
			coverLink.className = 'trackCoverLink';
			coverLink.target = '_blank';
			coverLink.href = trackInfo.coverUrl;
//			coverLink.href = getGoogleSearchImageLink(trackInfo.coverUrl);
			coverLink.style.backgroundImage = 'url('+trackInfo.coverUrl+')';
			nameRowEl.appendChild(coverLink);
		}
		
		if(trackInfo.name) {
			var nameSpan = document.createElement('span');
			nameSpan.className = 'trackName';
			nameSpan.innerHTML = trackInfo.name;
			nameRowEl.appendChild(nameSpan);
		}
//		if(trackInfo.status) statusRowEl.innerHTML = trackStatusAli[trackInfo.status];
		cont.appendChild(nameRowEl);
		cont.appendChild(actionsRowEl);
		var obj = {
			cont: cont,
			nameRowEl: nameRowEl,
			actionsRowEl: actionsRowEl
		};
		return obj;		
	}
	
	
	
	function getGoogleSearchImageLink(imageUrl) {
		var imageUrl = encodeURIComponent(imageUrl);
		return 'https://www.google.ru/searchbyimage?image_url='+imageUrl;
	}
	
	
	
	
	function getActionsTemplate(trackInfo) {
		var actionsRowEl = document.createElement('td');
		if(trackInfo.status === 'ready'){
			var downloadLink = document.createElement('a');
			downloadLink.classList.add('downloadTrackLink');
			downloadLink.innerHTML = 'Скачать';
			downloadLink.vkTrackID = trackInfo.id;
			downloadLink.vkSaveTabID = trackInfo.tabID;
			downloadLink.addEventListener('click', onDownloadButtonClick);
			actionsRowEl.appendChild(downloadLink);
		} else {
			actionsRowEl.innerHTML = trackStatusAli[trackInfo.status];
		}
		return {cont: actionsRowEl};
	}
	
	
	function onDownloadButtonClick(e) {
		e.preventDefault();
		if(this.vkTrackID && this.vkSaveTabID){
			sendMessageToPageScript(this.vkSaveTabID, 'downloadTrack', {id: this.vkTrackID});
		}
	}
	
	
	
	function setHtmlVars() {
		var temp;
		for(var i in htmlVars){
			if(htmlVars[i].type === 'id'){
				htmlVars[i] = document.getElementById(htmlVars[i].selector);
			} else if (htmlVars[i].type === 'class') {
				temp = document.body.getElementsByClassName(htmlVars[i].selector);
				if(htmlVars[i].index && htmlVars[i].index > 0){
					htmlVars[i] = temp[htmlVars[i].index];
				} else {
					htmlVars[i] = temp;
				}
			} else if (htmlVars[i].type === 'query') {
				htmlVars[i] = document.querySelector(htmlVars[i].selector);
			} else if (htmlVars[i].type === 'queryAll') {
				temp = document.body.querySelectorAll(htmlVars[i].selector);
				if(htmlVars[i].index && htmlVars[i].index > 0){
					htmlVars[i] = temp[htmlVars[i].index];
				} else {
					htmlVars[i] = temp;
				}
			}
		}
	}
	
	function isObjEmpty(obj) {
		for (var k in obj)
			return false;
		return true;
	}
	
	
	
}

