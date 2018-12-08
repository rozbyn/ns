




(function () {
	var myWebSocket;
	
	var address = document.getElementById('sock-addr');
	var mess = document.getElementById('sock-msg');
	
	var connectButton = document.getElementById('sock-conn-butt');
	var disconnectButton = document.getElementById('sock-disc-butt');
	var sendButton = document.getElementById('sock-send-butt');
	disconnectButton.disabled = true;
	sendButton.disabled = true;
	mess.disabled = true;
	
	var sockResponceCont = document.getElementById('sock-info');
	
	connectButton.addEventListener('click', sockedConnect);
	disconnectButton.addEventListener('click', sockedDisconnect);
	sendButton.addEventListener('click', sendMessage);
	
	function sendMessage () {
		if(myWebSocket) myWebSocket.send(mess.value);
	}
	
	
	function messToLog(mess) {
		var d = document.createElement('div');
		d.innerHTML = mess;
		sockResponceCont.appendChild(d);
	}
	
	
	function sockedConnect() {
		var adr = address.value;
		if(!myWebSocket || (myWebSocket && myWebSocket.url !== adr)){
			myWebSocket = new WebSocket(adr);
			
			myWebSocket.addEventListener('open', sockedOpen);
			myWebSocket.addEventListener('close', sockedClose);
			myWebSocket.addEventListener('message', sockedMessage);
			myWebSocket.addEventListener('error', sockedError);
		}
	}
	
	
	function sockedDisconnect() {
		if(myWebSocket){
			myWebSocket.close();
			

			
		}
	}
	

	function sockedOpen(a) {
		address.disabled = true;
		connectButton.disabled = true;

		sendButton.disabled = false;
		mess.disabled = false;
		disconnectButton.disabled = false;
		
		messToLog('socked opened at ' + a.target.url);
		console.log('sockedOpen',a);
	}

	function sockedClose(a) {
		address.disabled = false;
		connectButton.disabled = false;

		sendButton.disabled = true;
		mess.disabled = true;
		disconnectButton.disabled = true;
		
		myWebSocket = null;
		messToLog('socked closed at ' + a.target.url);
		console.log('sockedClose',a);
	}

	function sockedMessage(a) {
		messToLog('recive message from socked ('+a.target.url+') ' + ': '+ a.data);
		console.log('sockedMessage',a);
	}

	function sockedError(a) {
		messToLog('socked error ('+a.target.url+') ' + ': '+ a);
		console.log('sockedError',a);
	}
	
	
	
})();