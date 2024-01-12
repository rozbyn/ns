


/* global chrome */
var extKey = chrome.runtime.id;
var tabID;
var actionsHandlers = {
	"messageToPage": function (request, sender, sendResponse) {
		sendMessageToPageScript(request.pageAction, request.data);
		sendResponse(true);
	}
};

sendMessageToBackgroundScript('saveTabID', {}, function (thisTabID) {
	tabID = thisTabID;
	injectMainScript();
//	injectMp3TagScript();
});



















/*----------------------------------------------------------------------------*/



function injectMainScript() {
	var scriptEl = addScript("pageScript.js");
	scriptEl.id = 'saveVkAudioScript';
	scriptEl.setAttribute('saveVkAudioExtensionKey', extKey);
	scriptEl.setAttribute('saveVkAudioThisTabID', tabID);
}



function injectMp3TagScript() {
	addScript("mp3tag.js");
}



function addScript(url) {
	var scriptEl = document.createElement('script');
	scriptEl.type = 'text/javascript';
	scriptEl.src = chrome.runtime.getURL(url);
	document.head.appendChild(scriptEl);
	return scriptEl;
}



chrome.runtime.onMessage.addListener(messagesHandler);
//chrome.runtime.onMessageExternal.addListener(messagesHandler);



function messagesHandler(request, sender, sendResponse) {
	if(!checkMessage(request)) return;
	runActionHandler(request, sender, sendResponse);
}



function runActionHandler(request, sender, sendResponse) {
	if(request.action in actionsHandlers){
		return actionsHandlers[request.action](request, sender, sendResponse);
	} else {
		sendResponse(10000);
	}
}



function checkMessage(request) {
	var isValid = 
			request.target 
			&& request.target === 'content'
			&& request.extKey
			&& request.extKey === extKey
			&& request.action;
	return isValid;
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



function sendMessageToPopupScript(action, data, cb) {
	data = data || {};
	var objToSend = {
		target: 'popup',
		action: action,
		extKey: extKey,
		data: data
	};
	chrome.runtime.sendMessage(objToSend, cb);
}



function sendMessageToPageScript(action, data) {
	data = data || {};
	var objToSend = {
		target: 'page',
		action: action,
		extKey: extKey,
		data: data
	};
	window.postMessage(objToSend);
}






