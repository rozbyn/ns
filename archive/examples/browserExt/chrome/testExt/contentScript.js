
/* global chrome */
var extKey = chrome.runtime.id;
var tabID;
var actionsHandlers = {
	"messageToPage": function (request, sender, sendResponse) {
		sendMessageToPageScript(request.pageAction, request.data);
	}
};

sendMessageToBackgroundScript('saveTabID', {}, function (thisTabID) {
	tabID = thisTabID;
	injectScriptWithExtInfo();
	injectMainScript();
	injectSykaScript();
});




















/*----------------------------------------------------------------------------*/
function injectScriptWithExtInfo() {
	var scriptEl2 = document.createElement('script');
	scriptEl2.id = 'saveVkAudioScript2';
	scriptEl2.innerHTML = "var saveVkAudioExtensionKey = '" + extKey + "';";
	scriptEl2.innerHTML += "var saveVkAudioThisTabID = '" + tabID + "';";
	document.head.appendChild(scriptEl2);
}



function injectMainScript() {
	var scriptEl = document.createElement('script');
	scriptEl.type = 'text/javascript';
//	scriptEl.src = 'chrome-extension://'+chrome.runtime.id+'/pageScript.js';
	scriptEl.src = chrome.runtime.getURL("pageScript.js");
	document.head.appendChild(scriptEl);
}


function injectSykaScript() {
	var scriptEl = document.createElement('script');
	scriptEl.type = 'text/javascript';
//	scriptEl.src = 'chrome-extension://'+chrome.runtime.id+'/pageScript.js';
	scriptEl.src = chrome.runtime.getURL("info/findKeyInWindow.js");
	document.head.appendChild(scriptEl);
}



chrome.runtime.onMessage.addListener(messagesHandler);
//chrome.runtime.onMessageExternal.addListener(messagesHandler);



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






