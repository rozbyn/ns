


/* global chrome */



var messagesElements = document.querySelectorAll('[id^="message_"]');
for (var i = 0; i < messagesElements.length; i++) {
	var messageID = messagesElements[i].id.slice(8);
	var messageText = chrome.i18n.getMessage(messageID);
	if(messageText.length === 0) continue;
	messagesElements[i].innerHTML = messageText;
}


var link = document.getElementById('bitroidLink');
if(link){
	link.href = 'https://bitroid.ru/?utm_source=browser_extensions&utm_medium=chrome_extension&utm_campaign=bxfasteraudio_'+chrome.i18n.getUILanguage();
}



//console.log(chrome.i18n.getUILanguage());
//console.log(chrome.i18n.getMessage('appName'));
//console.log(chrome.i18n.getMessage('appDesc'));