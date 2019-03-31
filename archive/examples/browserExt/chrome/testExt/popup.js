
/* global chrome */



var contentScriptTabs = [];
var extKey = chrome.runtime.id;
var actionsHandlers = {
	"tracksInfo": function (request, sender, sendResponse) {
		jo.processTracksInfo(request.data);
	}
};



var jo = new popupWindowHandler;


sendMessageToBackgroundScript('getTracksInfo', 0 , processTracksInfo);




















/*----------------------------------------------------------------------------*/
var checkReadyInterval = false;
function processTracksInfo(newTracksInfo) {
	if(newTracksInfo === false){
		if(!checkReadyInterval){
			checkReadyInterval = setInterval(function () {
				console.log('checkReadyInterval');
				sendMessageToBackgroundScript('getTracksInfo', 0 , processTracksInfo);
			}, 200);
		}
	} else {
		sendMessageToBackgroundScript('getContentScriptTabs', 0 , function (taabs) {
			contentScriptTabs = taabs;
		});
		clearInterval(checkReadyInterval);
		jo.processTracksInfo(newTracksInfo);
	}
}



chrome.runtime.onMessage.addListener(messagesHandler);
chrome.runtime.onMessageExternal.addListener(messagesHandler);



function messagesHandler(request, sender, sendResponse) {
	if(!checkMessage(request)) return;
	runActionHandler(request, sender, sendResponse);
}



function runActionHandler(request, sender, sendResponse) {
	if(request.action in actionsHandlers){
		console.log(request.action, request.data);
		return actionsHandlers[request.action](request, sender, sendResponse);
	} else {
		sendResponse(10000);
	}
}



function checkMessage(request) {
	var isValid = 
			request.target 
			&& request.target === 'popup'
			&& request.extKey
			&& request.extKey === extKey
			&& request.action;
	return isValid;
}



function sendMessageToContentScript(tabID, action, data, cb) {
	data = data || {};
	if(contentScriptTabs.length <= 0) return (20000);
	var objToSend = {
		target: 'content',
		extKey: extKey,
		action: action,
		data: data
	};
	if(tabID && contentScriptTabs.indexOf(tabID) !== -1){
		chrome.tabs.sendMessage(tabID, objToSend, cb);
	} else if (tabID === 'all') {
		contentScriptTabs.forEach(function (y_tabID) {
			chrome.tabs.sendMessage(y_tabID, objToSend, cb);
		});
	}
}



function sendMessageToPageScript(tabID, action, data) {
	tabID = parseInt(tabID);
	data = data || {};
	if(contentScriptTabs.length <= 0) return;
	data = data || {};
	var objToSend = {
		target: 'content',
		extKey: extKey,
		action: 'messageToPage',
		pageAction: action,
		data: data
	};
	if(tabID && contentScriptTabs.indexOf(tabID) !== -1){
		console.log('sendMessageToPageScript', tabID, data);
		chrome.tabs.sendMessage(tabID, objToSend);
	} else if (tabID === 'all') {
		contentScriptTabs.forEach(function (y_tabID) {
			chrome.tabs.sendMessage(y_tabID, objToSend);
		});
	}
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
		'tracksTableBody': {'type': 'id', 'selector': 'tracksTableBody'}
	};
	setHtmlVars();
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	this.processTracksInfo = processTracksInfo;
	function processTracksInfo(newTracksInfo) {
		tracksInfo = newTracksInfo;
		renderTracks();
		console.log('processTracksInfo', newTracksInfo);
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
		var nameRowEl = document.createElement('td');
		var statusRowEl = document.createElement('td');
		var actionsRowEl = getActionsTemplate(trackInfo).cont;
		if(trackInfo.name) nameRowEl.innerHTML = trackInfo.name;
		if(trackInfo.status) statusRowEl.innerHTML = trackStatusAli[trackInfo.status];
		cont.appendChild(nameRowEl);
		cont.appendChild(statusRowEl);
		cont.appendChild(actionsRowEl);
		var obj = {
			cont: cont,
			nameRowEl: nameRowEl,
			statusRowEl: statusRowEl,
			actionsRowEl: actionsRowEl
		};
		return obj;		
	}
	
	
	
	function getActionsTemplate(trackInfo) {
		var actionsRowEl = document.createElement('td');
		if(trackInfo.status === 'ready'){
			var downloadLink = document.createElement('a');
			downloadLink.innerHTML = 'Скачать';
			downloadLink.vkTrackID = trackInfo.id;
			downloadLink.vkSaveTabID = trackInfo.tabID;
			downloadLink.addEventListener('click', onDownloadButtonClick);
			actionsRowEl.appendChild(downloadLink);
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
	
	
	
	
	
}

