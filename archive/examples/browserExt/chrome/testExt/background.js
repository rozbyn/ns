
/* global chrome */

// chrome.browserAction.setBadgeText({text: ''})
// chrome.browserAction.setBadgeBackgroundColor({color: '#00F'});
var scriptReady = false;
var a_tracksInfo = {};
var contentScriptTabs = [];
var extKey = chrome.runtime.id;

var actionsHandlers = {
	"saveTabID" : function (request, sender, sendResponse) {
		var id = sender.tab.id;
		contentScriptTabs.push(id);
		sendResponse(id);
	},
	"getContentScriptTabs" : function (request, sender, sendResponse) {
		sendResponse(contentScriptTabs);
	},
	"tracksInfo" : function (request, sender, sendResponse) {
		console.log('tracksInfo', request);
		a_tracksInfo = request.data;
		sendMessageToPopupScript('tracksInfo', request.data);
		sendResponse(true);
	},
	"getTracksInfo": function (request, sender, sendResponse) {
		if(!scriptReady) sendResponse(false);
		sendResponse(a_tracksInfo);
	},
	"pageScriptReady": function (request, sender, sendResponse) {
		scriptReady = true;
		sendResponse(true);
	}
};




















/*----------------------------------------------------------------------------*/
chrome.runtime.onMessage.addListener(messagesHandler);
chrome.runtime.onMessageExternal.addListener(messagesHandler);



function messagesHandler(request, sender, sendResponse) {
	if(!checkMessage(request)) return;
	runActionHandler(request, sender, sendResponse);
}



chrome.tabs.onRemoved.addListener(function (tabId, removeInfo) {
	removeValueFromArray(tabId, contentScriptTabs);
});



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
			&& request.target === 'background'
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



function sendMessageToPopupScript(action, data, cb) {
	data = data || {};
	var objToSend = {
		target: 'popup',
		extKey: extKey,
		action: action,
		data: data
	};
	chrome.runtime.sendMessage(objToSend, cb);
}



function sendMessageToPageScript(tabID, action, data) {
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
		chrome.tabs.sendMessage(tabID, objToSend);
	} else if (tabID === 'all') {
		contentScriptTabs.forEach(function (y_tabID) {
			chrome.tabs.sendMessage(y_tabID, objToSend);
		});
	}
}



function removeValueFromArray (value, array) {
	var i = array.indexOf(value);
	if(i !== -1){
		array.splice(i, 1);
		return array;
	}
}
