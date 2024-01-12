/* global BX, chrome */
var DEV_MODE = false;

if(DEV_MODE) console.log('contentScript.js included');

var script = document.createElement('script');
script.id = 'BxFasterAudioExtensionScriptElement';
script.innerHTML = '('+

function (DEV_MODE, extKey) {
	if(typeof BX !== 'function' || typeof BX.addCustomEvent !== 'function') return;
	
	var avalRate = [
		{value:1, name: 'x1'},
		{value:1.25, name: 'x1.25'},
		{value:1.5, name: 'x1.5'},
		{value:2, name: 'x2'}
	];

	function onevent(playerObj) {
		if(
				!playerObj
				|| typeof playerObj !== 'object'
				|| typeof playerObj.vjsPlayer !== 'object'
				|| typeof playerObj.vjsPlayer.el_ !== 'object'
				|| typeof playerObj.vjsPlayer.tech_ !== 'object'
				|| typeof playerObj.vjsPlayer.tech_.el_ !== 'object'
		) return;
		
		if(DEV_MODE) console.log('Player:onAfterInit');
		
		var audioWrapper = playerObj.vjsPlayer.el_;
		var audioEl = playerObj.vjsPlayer.tech_.el_;

		var progressBarWrapper = audioWrapper.querySelector('.vjs-control-bar > .vjs-progress-control');

		if(!progressBarWrapper) return;
		var playRateControlWrap = document.createElement('div');
		var rateSelect = document.createElement('select');
		rateSelect.style.cssText = "";
		playRateControlWrap.style.color = 'inherit';
		
		if(audioWrapper.classList.contains('vjs-timeline_player-skin')){
			progressBarWrapper.style.right = '80px';
			playRateControlWrap.style.right = '39px';			
			playRateControlWrap.style.color = '#979da4';
		} else if (audioWrapper.classList.contains('vjs-viewer-audio-player-skin')) {
			progressBarWrapper.style.width = '143px';
			playRateControlWrap.style.right = '59px';
		}


		
		playRateControlWrap.style.width = '36px';
		playRateControlWrap.style.height = '100%';
		playRateControlWrap.style.position = 'absolute';
		playRateControlWrap.style.top = '0';
		audioWrapper.appendChild(playRateControlWrap);

		rateSelect.style.cssText = 'color: inherit;';
		rateSelect.style.cssText += "width: 100%;";
		rateSelect.style.cssText += "font-size: 12px;";
		rateSelect.style.cssText += "height: 100%;";
		rateSelect.style.cssText += "outline: none;";
		rateSelect.style.cssText += "border: 0;";
		rateSelect.style.cssText += "padding: 0;";
		rateSelect.style.cssText += "-webkit-appearance: none;";
		rateSelect.style.cssText += "-moz-appearance: none;";
		rateSelect.style.cssText += "appearance: none;";
		rateSelect.style.cssText += "text-align: center;";
		rateSelect.style.cssText += "text-align-last: center;";
		rateSelect.style.cssText += "background: inherit;";

    avalRate.forEach(function (rateInf) {
			var opt = document.createElement('option');
			opt.innerHTML = rateInf.name;
			opt.value = rateInf.value;
			opt.style.color = '#2c2c2c';
			rateSelect.appendChild(opt);
		});

		playRateControlWrap.appendChild(rateSelect);

    rateSelect.addEventListener('change', function () {
			audioEl.playbackRate = this.value;
		});
	}
	
	
	
	if(DEV_MODE) console.log('injecting into BX');
	var scriptElement = document.getElementById('BxFasterAudioExtensionScriptElement');
	if(scriptElement){
		scriptElement.dispatchEvent(new CustomEvent('load'));
	}
	
	
	BX.addCustomEvent('Player:onAfterInit',onevent);
	
	if(
			typeof BX === 'function' 
			&& typeof BX.Fileman === 'object' 
			&& typeof BX.Fileman.PlayerManager === 'object'
			&& typeof BX.Fileman.PlayerManager.players === 'object'
			&& typeof BX.Fileman.PlayerManager.players.length
	){
		for (var i = 0; i < BX.Fileman.PlayerManager.players.length; i++) {
			var playerObj = BX.Fileman.PlayerManager.players[i];
			if(playerObj.inited){
				onevent(playerObj);
			}
		}
	}
}
+ ')('+DEV_MODE+', "'+chrome.runtime.id+'");';

if(document && document.head){
	script.onload = function () {
		chrome.runtime.sendMessage(chrome.runtime.id, 'BxFasterAudio success injected!', function () {
			if(DEV_MODE) console.log('messageCB', arguments);
			if(DEV_MODE) console.log('chrome.runtime.lastError', chrome.runtime.lastError);
		});
	};
	document.head.appendChild(script);
	
}


