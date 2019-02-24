

// chrome.browserAction.setBadgeText({text: ''})
// chrome.browserAction.setBadgeBackgroundColor({color: '#00F'});

setInterval(function () {
//	console.log('Privet');
} ,2000);

  chrome.runtime.onInstalled.addListener(function() {
    console.log('onInstalled');
  });