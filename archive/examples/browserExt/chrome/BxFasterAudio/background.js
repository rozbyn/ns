/* global chrome */



chrome.runtime.onMessage.addListener(function (request, sender, sendResponse) {
	if(request !== 'BxFasterAudio success injected!') return sendResponse(false);
	chrome.browserAction.setIcon({path: 'pic/icon16_2.png', tabId: sender.tab.id});
	return sendResponse(true);
});
