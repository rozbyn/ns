/* global URL, Blob */

var z_util = {
	doNothing: function() {},
	
	
	
	
	
	makeElFromTempl: function (template) {
		if('nN' in template){
			if('nN' === 'textNode'){
				var n1 = document.createTextNode('');
			} else {
				var n1 = document.createElement(template.nN);
			}
			
		} else {
			return document.createElement('span');
		}
		var mainInputs = {};
		for(var i in template){
			if(i === 'nN') continue;
			if(i === 'mainInput') mainInputs[template.mainInput] = n1;
			if(i === 'ch'){
				for(var j in template[i]){
					if(
							'container' in template[i][j] 
							&& typeof template[i][j].container === 'object' 
							&& template[i][j].container.nodeType
					){
						var chTempl = template[i][j];
					} else {
						chTempl = z_util.makeElFromTempl(template[i][j]);
					}
					n1.appendChild(chTempl.container);
					for(var k in chTempl.inputs){
						mainInputs[k] = chTempl.inputs[k];
					}
				}
			} else {
				n1[i] = template[i];
			}
			
		}
		return {container: n1, inputs: mainInputs};
	},
	
	
	
	
	
	ajaxSendFile : function(url, file, params, callback) {
		callback = callback || z_util.doNothing;
		params = typeof params === 'object' ? params : {};
		var formData = new FormData();
		formData.append('file',file);
		var request = new XMLHttpRequest();
		request.onreadystatechange = function () {
			if (request.readyState === 4 && request.status === 200) {
				callback(request.responseText);
			}
		};
		
		for (var i in params) {
			formData.append(i, params[i]);
		}
		
		request.open('POST', url);
		request.send(formData);
		return request;
	},
	
	
	
	
	
	ajaxPost: function (url, params, callback) {
		var method = 'GET';
		if (typeof params === 'object' && !z_util.isObjEmpty(params)) {
			var paramsToSend = z_util.encodeObj(params);
			method = 'POST';
		} else if (typeof params === 'string' || typeof params === 'number') {
			paramsToSend = params;
			method = 'POST';
		} else {
			paramsToSend = '';
		}
		var request = new XMLHttpRequest();
		var f = callback || z_util.doNothing;
		request.onreadystatechange = function () {
			if (request.readyState === 4 && request.status === 200) {
				f(request.responseText);
			}
		};
		request.open(method, url);
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		request.send(paramsToSend);
	},
	
	
	
	
	
	encodeObj: function (obj, prefix) {
		var str = [],
				p;
		for (p in obj) {
			if (obj.hasOwnProperty(p)) {
				var k = prefix ? prefix + "[" + p + "]" : p,
						v = obj[p];
				str.push((v !== null && typeof v === "object") ?
						z_util.encodeObj(v, k) :
						encodeURIComponent(k) + "=" + encodeURIComponent(v));
			}
		}
		return str.join("&");
	},
	
	
	
	
	
	findParent : function (el, selector, selectorType) {
		if(!el || !el.nodeName) return false;
		selector = selector || 'DIV';
		selectorType = selectorType || 'nodeName';
		var par = el, parFinded = false;
		do {
			if(selectorType === 'nodeName'){
				parFinded = par.nodeName === selector;
				
			} else if (selectorType === 'id') {
				parFinded = par.id === selector;
				
			} else if (selectorType === 'class') {
				parFinded = par.classList.contains(selector);
				
			}
			if(!parFinded) par = par.parentNode;
		} while (!parFinded && par !== document);
		if(parFinded && par && par !== document && par.nodeName) return par;
		return false;
	},
	
	
	
	
	
	clearNodeChildrens: function (el) {
		while (el.firstChild) {
			el.removeChild(el.firstChild);
		}
	},
	
	
	
	
	
	removeNode: function(node) {
		if(node.parentNode) node.parentNode.removeChild(node);
	},
	
	
	
	
	
	isParentEl : function (parent, el) {
		var par = el;
		while(par !== parent && par !== document) par = par.parentNode;
		return par === parent && par !== document;
	},
	
	
	
	
	
	isObjEmpty: function (obj) {
		for (var k in obj)
			return false;
		return true;
	},
	
	
	
	
	
	isNotEmptyObject: function (obj) {
		return !!(obj && (typeof obj === 'object') && !z_util.isObjEmpty(obj));
	},
	
	
	
	
	
	clearTextSelection : function () {
		if (window.getSelection) {
			if (window.getSelection().empty) {  // Chrome
				window.getSelection().empty();
			} else if (window.getSelection().removeAllRanges) {  // Firefox
				window.getSelection().removeAllRanges();
			}
		} else if (document.selection) {  // IE?
			document.selection.empty();
		}
	},
	
	
	
	
	
	uniqueArray: function(arr) {
		var newArr = [];
		arr.forEach(function (el) {
			if(newArr.indexOf(el) === -1) newArr.push(el);
		});
		return newArr;
	},
	
	
	
	
	
	copyObjDeep: function (obj) {
		return JSON.parse(JSON.stringify(obj));
	},
	
	
	
	
	
	isPositiveInt: function (s) {
		return  z_util.isInt(s) && parseInt(s) > 0;
	},
	
	
	
	
	
	isInt: function (s) {
		if(typeof s === 'number'){
			return parseInt(s) === s;
		} else if (typeof s === 'string'){
			return (''+parseInt(s)) === s;
		}
		return false;
	},
	
	
	
	
	
	jsonStringfy: function (obj) {
		var res = false;
		try {
			res = JSON.stringify(obj);
		} catch (e) {}
		return res;
	},
	
	
	
	
	
	jsonParse: function (str) {
		var res = false;
		try {
			res = JSON.parse(str);
		} catch (e) {}
		return res;
	},
	
	
	
	
	
	getFirstObjectKeyData : function (obj) {
		if(typeof obj !== 'object') return;
		for (var i in obj) {
			return obj[i];
		}
	},
	
	
	
	
	
	isAllTrue: function (obj) {
		if(typeof obj !== 'object') return false;
		if(typeof obj.length === 'number'){
			if(obj.length > 0){
				for (var i = 0; i < obj.length; i++) {
					if(!obj[i]) return false;
				}
			} else {
				return false;
			}
		} else if (z_util.isObjEmpty(obj)) {
			return false;
		} else {
			for (var item in obj) {
				if(!obj[item]) return false;
			}
		}
		return true;
	},
	
	
	
	
	
	isAllFalse: function (obj) {
		if(typeof obj !== 'object') return null;
		if(typeof obj.length === 'number'){
			if(obj.length > 0){
				for (var i = 0; i < obj.length; i++) {
					if(obj[i]) return false;
				}
			} else {
				return null;
			}
		} else if (z_util.isObjEmpty(obj)) {
			return null;
		} else {
			for (var item in obj) {
				if(obj[item]) return false;
			}
		}
		return true;
	},
	
	
	
	
	
	inArray: function (search, array)	{
		for (var i = 0; i < array.length; i++) {
			if (array[i] == search) return true;
		}
		return false;
	},
	
	
	
	
	
	extend: function (child, parent) {
		var F = function() {};
		F.prototype = parent.prototype;

		child.prototype = new F();
		child.prototype.constructor = child;

		child.superclass = parent.prototype;
		child.prototype.superclass = parent.prototype;
		if (parent.prototype.constructor == Object.prototype.constructor){
			parent.prototype.constructor = parent;
		}
	},
	
	
	
	
	
	mergeParams: function (defaultParams, currentParams) {
		if (typeof defaultParams !== 'object') defaultParams = {};
		if (typeof currentParams !== 'object') currentParams = {};
		var params = {};
		for (var param in defaultParams) {
			params[param] = ((param in currentParams) && typeof defaultParams[param] === typeof currentParams[param]) ?
					currentParams[param] : defaultParams[param];
		}
		return params;
	},
	
	
	
	
	
	getParam: function (obj, paramName, defaultValue) {
		if(!obj || typeof obj !== 'object') return defaultValue;
		if(paramName in obj) return obj[paramName];
		return defaultValue;
	},
	
	
	
	
	
	padNumToDigit: function (num, digit) {
		digit = digit || 4;
		var sign = num < 0 ? '-' : '';
		var d = digit - ('' + num).length;
		var str = sign;
		for (var i = 0; i < d; i++)
			str += '0';
		return str += num;
	},
	
	
	
	
	
	showElemSlideDown: function (el, speedMs, displayValue, cb) {
//		log('showElemSlideDown');
		if(typeof displayValue !== 'string'){
			displayValue = '';
		}
//		if(el.style.display === displayValue || el.clientHeight > 0) return;
		if(typeof speedMs !== 'number' || speedMs < 0){
			speedMs = 200;
		}
		speedMs = parseInt(speedMs);
		if(typeof cb !== 'function') cb = z_util.doNothing;
		if(!z_util.checkBeforeRunSlideCommand('showElemSlideDown', el, speedMs, displayValue, cb)) return;
		var emulateTransitionend = !('ontransitionend' in el);
		var intervalWorked = false;
		var transitionWorked = false;
		var intervalCount = 0;
		var intervalCb = function () {
			if(transitionWorked) return clearInterval(interval);
			intervalCount++;
			if(intervalCount > 25 || el.clientHeight === newHeight) {
				intervalWorked = true;
				clearInterval(interval);
				el.style.overflow = '';
				el.style.height = '';
				el.style.transition = '';
//					log('transitionend emulate show');
				cb();
				z_util.afterRunSlideCommand('showElemSlideDown', el);
			}
		};
		var trEndCb = function (e) {
			if(e.target === el && e.propertyName === 'height'){
				transitionWorked = true;
				el.removeEventListener('transitionend', trEndCb);
				if(intervalWorked) return;
				el.style.overflow = '';
				el.style.height = '';
				el.style.transition = '';
//					log('transitionend show');
				cb();
				z_util.afterRunSlideCommand('showElemSlideDown', el);
			}
		};
		var lastHeight = el.clientHeight;
		var lastDisplayValue = el.style.display;
		el.style.display = displayValue;
		var newHeight = el.clientHeight;
		el.style.display = lastDisplayValue;
		el.style.overflow = 'hidden';
		el.style.height = lastHeight + 'px';
		el.style.display = displayValue;
		el.style.transition = 'height '+speedMs+'ms linear 0s';
		if(!emulateTransitionend) el.addEventListener('transitionend', trEndCb);
		var interval;
		setTimeout(function () {
			el.style.height = newHeight + 'px';
			if(1 || emulateTransitionend){
				setTimeout(function () {
					interval = setInterval(intervalCb, 20);
				}, speedMs);
			}
		},1);
//		(function () {
//			var count = 101;
//			var currI = 0;
//			var speed = 20;
//			var bob = $0;
//			function runQueueueue() {
//				if (currI > count)
//					return;
//				currI++;
//				bob.dispatchEvent(new MouseEvent('click'));
//				setTimeout(runQueueueue, speed);
//			}
//			runQueueueue();
//		})();
	},
	
	
	
	
	
	nextSlideCommands: [],
	currentSlideCommands: [],
	findElementInSlideCommands: function (el, arr) {
		for (var i = 0; i < arr.length; i++) {
			if(arr[i].el === el) return arr[i];
		}
		return false;
	},
	
	
	
	
	
	checkBeforeRunSlideCommand: function (func, el, speedMs, displayValue, cb) {
		var currCommand = z_util.findElementInSlideCommands(el, z_util.currentSlideCommands);
		if (currCommand) {
//			console.log('beforeRun::commForElExist', currCommand.func);
			var nextCommForEl = z_util.findElementInSlideCommands(el, z_util.nextSlideCommands);
			if (nextCommForEl) {
//				console.log('beforeRun::nextCommForElExist', nextCommForEl.func);
				nextCommForEl.func = func;
				nextCommForEl.el = el;
				nextCommForEl.speedMs = speedMs;
				nextCommForEl.displayValue = displayValue;
				nextCommForEl.cb = cb;
			} else {
				var thisCommObj = {func: func, el: el, speedMs: speedMs, displayValue: displayValue, cb: cb};
				z_util.nextSlideCommands.push(thisCommObj);
//				console.log('beforeRun::nextCommForElNotExist', func);
			}
			return false;
		}
//		console.log('beforeRun::commForElNotExist', func);
		var thisCommObj = {func: func, el: el, speedMs: speedMs, displayValue: displayValue, cb: cb};
		z_util.currentSlideCommands.push(thisCommObj);
		return true;
	},
	
	
	
	
	
	afterRunSlideCommand: function (func, el) {
		var elCurrCommand = z_util.findElementInSlideCommands(el, z_util.currentSlideCommands);
		if(!elCurrCommand) {
//			console.log('afterRun::elCurrCommandNotExist', func);
			return;
		}
//		console.log('afterRun::elCurrCommandExist', func, elCurrCommand.func);
		var currCommandIndex = z_util.currentSlideCommands.indexOf(elCurrCommand);
		z_util.currentSlideCommands.splice(currCommandIndex, 1);
		var elNextCommand = z_util.findElementInSlideCommands(el, z_util.nextSlideCommands);
		if(!elNextCommand) {
//			console.log('afterRun::elNextCommandNotExist', func);
			return;
		}
//		console.log('afterRun::elNextCommandExist', elNextCommand.func);
		var nextCommandIndex = z_util.nextSlideCommands.indexOf(elNextCommand);
		z_util.nextSlideCommands.splice(nextCommandIndex, 1);
		z_util[elNextCommand.func](elNextCommand.el, elNextCommand.speedMs, elNextCommand.displayValue, elNextCommand.cb);
	},
	
	
	
	
	
	hideElemSlideUp: function (el, speedMs, nodisplayValue, cb) {
		if(typeof nodisplayValue !== 'string'){
			nodisplayValue = 'none';
		}
//		if(el.style.display === nodisplayValue || el.clientHeight === 0) return;
		if(typeof speedMs !== 'number' || speedMs < 0){
			speedMs = 200;
		}
		speedMs = parseInt(speedMs);
		if(typeof cb !== 'function') cb = z_util.doNothing;
		if(!z_util.checkBeforeRunSlideCommand('hideElemSlideUp', el, speedMs, nodisplayValue, cb)) return;
		var emulateTransitionend = !('ontransitionend' in el);
		var transitionWorked = false;
		var intervalWorked = false;
		var intervalCount = 0;
		var intervalCb = function () {
			if(transitionWorked) return clearInterval(interval);
			intervalCount++;
			if (intervalCount > 25 || el.clientHeight === 0) {
				intervalWorked = true;
				clearInterval(interval);
				el.style.display = nodisplayValue;
				el.style.overflow = '';
				el.style.height = '';
				el.style.transition = '';
				cb();
				z_util.afterRunSlideCommand('hideElemSlideUp', el);
//					log('transitionend emulate hide');
			}
		};
		var trEndCb = function (e) {
			if(e.target === el && e.propertyName === 'height'){
				transitionWorked = true;
				el.removeEventListener('transitionend', trEndCb);
				if(intervalWorked) return;
				el.style.display = nodisplayValue;
				el.style.overflow = '';
				el.style.height = '';
				el.style.transition = '';
				cb();
				z_util.afterRunSlideCommand('hideElemSlideUp', el);
//					log('transitionend hide');
			}
		};
		var currHeight = el.clientHeight;
		el.style.height = currHeight + 'px';
			
//		return;
		el.style.overflow = 'hidden';
		el.style.transition = 'height '+speedMs+'ms linear 0s';
		if(!emulateTransitionend) el.addEventListener('transitionend', trEndCb);
		var interval;
		setTimeout(function () {
			el.style.height = 0 + 'px';
			if (1 || emulateTransitionend) {
				setTimeout(function () {
					interval = setInterval(intervalCb, 20);
				}, speedMs);
			}
		},1);
	},
	
	
	
	
	
	waitAnimationEnd: function (el, prop, finalValue, cb) {
		if(typeof cb !== 'function') return false;
		var i = 0;
		var intervalFunc = function () {
			i++;
//			console.log(prop, el[prop], finalValue);
			if(typeof el[prop] === 'undefined' || el[prop] === finalValue || i > 200){
				clearInterval(interval);
				cb();
			}
		};
		var interval = setInterval(intervalFunc, 50);
	},
	
	
	
	
	
	hashString: function(s) { // https://stackoverflow.com/questions/7616461/generate-a-hash-from-string-in-javascript
    var hash = 0,
      i, l, char;
    if (s.length == 0) return hash;
    for (i = 0, l = s.length; i < l; i++) {
      char = s.charCodeAt(i);
      hash = ((hash << 5) - hash) + char;
      hash |= 0; // Convert to 32bit integer
    }
    return hash;
  },
	
	
	
	
	
	runAfterAllAsynch: function(endFunc) {
		if(typeof endFunc !== 'function'){
			throw new Error('First argument must be a function');
		}
		var self = this;
		self.endFunc = endFunc;
		self.started = false;
		self.currIndex = 0;
		self.successFuncFlags = {};
		self.checkFunc = function () {
			if(self.started && z_util.isAllTrue(self.successFuncFlags)){
				self.endFunc();
			}
		};
		self.wrapFunction = function (cb) {
			if(typeof cb !== 'function') cb = z_util.doNothing;
			var functionIndex = self.currIndex;
			self.successFuncFlags[functionIndex] = false;
			self.currIndex++;
			return function () {
				cb.apply(this, arguments);
				self.successFuncFlags[functionIndex] = true;
				self.checkFunc();
			};
		};
		self.start = function () {
			self.started = true;
			self.checkFunc();
		};
  },
	
	
	
	
	
	
	declOfNum: function (n, titles) {
		return titles[n%10==1 && n%100!=11 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2];
	},
	
	
	
	
	
	
	swapObjectKeysValues: function (obj) {
		if(!z_util.isNotEmptyObject(obj)) return obj;
		var result = {};
		for (var i in obj) {
			if(typeof obj[i] === 'object' || typeof obj[i] === 'function') continue;
			result[ obj[i] ] = i;
		}
		return result;
	},
	
	
	
	
	
	
	makeFileDownloadLink: function (data, filename, type) {
		if(data instanceof Blob){
			var file = data;
		} else {
			file = new Blob([data], {type: type});
		}
		var a = document.createElement("a");
		var url = URL.createObjectURL(file);
		a.href = url;
		a.download = filename;
		a.innerHTML = filename;
		return a;
	},
	
	
	
	
	
	
	strReplaceObjDeep: function (object, findStr, replaceToStr) {
		if(!z_util.isNotEmptyObject(object)) return;
		for (var i in object) {
			if(typeof object[i] === 'string'){
				object[i] = object[i].replace(findStr, replaceToStr);
			} else if (z_util.isNotEmptyObject(object[i])){
				z_util.strReplaceObjDeep(object[i], findStr, replaceToStr);
			}
		}
	},
	
	
	
	
	
	
	isNotEmptyString: function (str) {
		return (typeof str === 'string' || typeof str === 'number') 
		&& (''+str).length > 0;
	}
	
	
	
};