
var z_util = {
	doNothing: function() {},

	ajaxSendForm : function(url, params, callback) {
		callback = callback || z_util.doNothing;
		params = typeof params === 'object' ? params : {};
		var formData = new FormData();
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



	encodeObj: function (obj) {
		var query = Object.keys(obj)
				.map(function (k) {
					return encodeURIComponent(k) + '=' + encodeURIComponent(obj[k]);
		})
				.join('&');
		return query;
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
		while(par && par !== parent && par !== document) {
			par = par.parentNode;
		}
		return par === parent && par !== document;
	},



	isObjEmpty: function (obj) {
		for (var k in obj)
			return false;
		return true;
	},
	
	
	getObjLength: function (obj) {
		if(typeof obj !== 'object') return false;
		if('length' in obj) return obj.length;
		var i = 0;
		for (var k in obj) i++;
		return i;
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
		if(typeof s === 'number'){
			return (parseInt(s) ===  s) && (s > 0);
		} else if (typeof s === 'string'){
			return ((''+parseInt(s)) === s) && parseInt(s) > 0;
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
	
	
	inArray: function (search, array) {
		if(!array || !array.length) return false;
		for (var i = 0; i < array.length; i++) {
			if(array[i] == search) return true;
		}
		return false;
	},


};



function FileSynchronizer(fileInfo, collection, index) {
	var self = this;
	
	self.index = index;
	self.collection = collection;
	self.fileInfo = fileInfo;
	self.container = self.collection.activeSynchContainer;
	
	self.lastFileTs = self.fileInfo.file.lastModified;
	self.synchCount = 0;
	self.isFileSending = false;
	self.mustReSendFile = false;
	self.fileOpenedWindows = [];
	
	self.element = false;
	self.windowCheckbox = false;
	self.indicatorElement = false;
	self.synchCountElement = false;
	self.stopSynchElement = false;
	
	
	self.init = function () {
		self.renderSynchItem();
		
	};
	
	
	self.renderSynchItem = function () {
		var templ = self.getSynchItemTemplate(self.fileInfo);
		self.element = templ.element;
		self.windowCheckbox = templ.windowCheckbox;
		self.indicatorElement = templ.indicatorElement;
		self.synchCountElement = templ.synchCountElement;
		self.stopSynchElement = templ.stopSynchElement;
		self.stopSynchElement.addEventListener('click', self.stopSynch);
		
		self.container.appendChild(self.element);
	};
	
	
	self.getSynchItemTemplate = function (fileInfo) {
		var tr = document.createElement('tr');
		var td1 = document.createElement('td');
		var td2 = document.createElement('td');
		var td3 = document.createElement('td');
		var td4 = document.createElement('td');
		var td5 = document.createElement('td');
		
		if(typeof fileInfo.href === 'string' && fileInfo.href.length > 0){
			var a = document.createElement('a');
			a.href = fileInfo.href;
			a.innerHTML = fileInfo.name;
			a.target = '__blank';
			a.addEventListener('click', self.onClickFileLink);
			td1.appendChild(a);
		} else {
			td1.innerHTML = fileInfo.name;
		}
		
		var windowCheckbox = document.createElement('input');
		windowCheckbox.type = 'checkbox';
		windowCheckbox.title = 'Обновлять вкладки (окна), когда обновляется файл?';
		td2.appendChild(windowCheckbox);
		
		var indicator = document.createElement('div');
		indicator.classList.add('loadingStatusIndicator');
		td3.appendChild(indicator);
		
		var stopIcon = document.createElement('div');
		stopIcon.classList.add('stopSynchIcon');
		stopIcon.innerHTML = '&#10799;';
		td5.appendChild(stopIcon);
		
		td4.innerHTML = 0;
		
		tr.appendChild(td1);
		tr.appendChild(td2);
		tr.appendChild(td3);
		tr.appendChild(td4);
		tr.appendChild(td5);
		
		var returnObj = {
			element: tr,
			windowCheckbox: windowCheckbox,
			indicatorElement: indicator,
			synchCountElement: td4,
			stopSynchElement: stopIcon,
		};
		
		return returnObj;
	};
	
	
	
	self.onClickFileLink = function (e) {
		var fileWindow = window.open(this.href);
		if(fileWindow && fileWindow.closed === false){
			e.preventDefault();
			e.stopPropagation();
			self.fileOpenedWindows.push(fileWindow);
		}
	};
	
	
	self.refreshFileWindows = function () {
		if(!self.windowCheckbox.checked) return;
		var deleteWindows = [];
		for (var i = 0; i < self.fileOpenedWindows.length; i++) {
			var wind = self.fileOpenedWindows[i];
			if(!wind){
				deleteWindows.push(i);
				continue;
			}
			if(wind.closed){
				deleteWindows.push(i);
			} else {
				wind.location.reload();
			}
		}
		for (var j = 0; j < deleteWindows.length; j++) {
			var wIndex = deleteWindows[j];
			self.fileOpenedWindows.splice(wIndex, 1);
		}
	};


	

	
	self.stopSynch = function () {
		z_util.removeNode(self.element);
		self.collection.removeFileSynchronizer(self);
	};


	self.onCheckIntervalTick = function () {
		console.log('onCheckIntervalTick', self.fileInfo.file);
		if(self.fileInfo.file.lastModified === self.lastFileTs) return;
		self.lastFileTs = self.fileInfo.file.lastModified;
		if(self.isFileSending) {
			self.mustReSendFile = true;
			return;
		}
		
		self.sendModifiedFile(self.fileInfo, self.sendFileCallback);
	};
	
	
	self.sendModifiedFile = function (fileInfo, cb) {
		self.isFileSending = true;
		self.indicatorElement.classList.add('loading');
		var ajaxParams = {
			modifiedFile: fileInfo.file,
			PATH: fileInfo.path,
			ACTION: 'SAVE_FILE_CONTENT',
		};
		z_util.ajaxSendForm(location.href, ajaxParams, cb);
	};
	
	
	
	
	self.sendFileCallback = function (data) {
		self.isFileSending = false;
		self.indicatorElement.classList.remove('loading');
		data = z_util.jsonParse(data);
		if(typeof data !== 'object') return self.sendFatalError('Incorrect server response');
		if('ERROR' in data) return self.sendFatalError(data.ERROR);
		if(data.SUCCESS === 'Y' && parseInt(data.WRITING_BYTES) > 0){
			self.synchCount++;
			self.synchCountElement.innerHTML = self.synchCount;
			if(self.mustReSendFile){
				console.log('mustReSendFile');
				self.mustReSendFile = false;
				self.sendModifiedFile(self.fileInfo, self.sendFileCallback);
			} else {
				self.refreshFileWindows();
			}
		}
	};


	self.sendFatalError = function (msg) {
		self.collection.app.showMessage(msg, true);
		clearInterval(self.collection.checkInterval);
	};

	
	
	
	
	
	self.init();
}


function FileSynchronizerCollection(app) {
	var self = this;
	self.app = app;
	self.lastFileSynchPopupFileInfo = false;
	self.activeFileSynchonizers = {};
	self.activeSynchContainer = false;
	
	self.checkInterval = false;
	self.checkIntervalMs = 100;
	
	self.init = function () {
		document.addEventListener("DOMContentLoaded", self.initDOM);
	};
	
	self.initDOM = function () {
		self.initHtmlVars();
		self.addDomListeners();
		self.activeSynchContainer = yz.activeSynchItemsTbody;
	};


	
	
	self.initHtmlVars = function () {
		for (var i in self.htmlVars) {
			if (self.htmlVars[i].type === 'id') {
				var el = document.getElementById(self.htmlVars[i].selector);
				self.htmlVars[i] = el;
			} else if (self.htmlVars[i].type === 'query') {
				el = document.querySelector(self.htmlVars[i].selector);
				self.htmlVars[i] = el;
			} else if (self.htmlVars[i].type === 'queryAll') {
				el = document.querySelectorAll(self.htmlVars[i].selector);
				self.htmlVars[i] = el;
			}
		}
	};

	self.htmlVars = {
		'synchFilePopupOverlay': {type: 'id', selector: 'synchFilePopupOverlay'},
		'headerFileName': {type: 'id', selector: 'headerFileName'},
		'closePopupBtn': {type: 'id', selector: 'closePopupBtn'},
		'serverFileName': {type: 'id', selector: 'serverFileName'},
		'serverFilePathLink': {type: 'id', selector: 'serverFilePathLink'},
		'dropFileArea': {type: 'id', selector: 'dropFileArea'},
		'dropFileHereText': {type: 'id', selector: 'dropFileHereText'},
		'localFileInput': {type: 'id', selector: 'localFileInput'},
		
		'activeSynchWindow': {type: 'id', selector: 'activeSynchWindow'},
		'activeSynchMinimizeIcon': {type: 'id', selector: 'activeSynchMinimizeIcon'},
		'activeSynchItemsTbody': {type: 'id', selector: 'activeSynchItemsTbody'},
	};
	var yz = self.htmlVars;
	
	
	self.addDomListeners = function () {
		yz.synchFilePopupOverlay.addEventListener('click', self.onClickPopupOverlay);
		yz.closePopupBtn.addEventListener('click', self.onClickClosePopupBtn);
		
		yz.dropFileArea.addEventListener("dragenter", self.dropFileAreaDragOver);
		yz.dropFileArea.addEventListener("dragover", self.dropFileAreaDragOver);
		yz.dropFileArea.addEventListener("dragleave", self.dropFileAreaDragLeave);
		yz.dropFileArea.addEventListener("dragend", self.dropFileAreaDragLeave);
		yz.dropFileArea.addEventListener("dragexit", self.dropFileAreaDragLeave);
		yz.dropFileArea.addEventListener("drop", self.dropFileAreaDrop);
		yz.dropFileArea.addEventListener("click", self.onClickFileDropArea);
		
		yz.localFileInput.addEventListener("change", self.onChangeFileInput);
		
	};
	
	
	self.onClickFileDropArea = function () {
		yz.localFileInput.click();
	};

	
	self.onClickPopupOverlay = function (e) {
//		if(e.target === yz.synchFilePopupOverlay) self.hideFileSynchPopup();
	};
	
	self.onClickClosePopupBtn = function (e) {
		if(e.target === yz.closePopupBtn) self.hideFileSynchPopup();
	};
	
	self.openFileSynchPopup = function () {
		if(!self.lastFileSynchPopupFileInfo) return;
		self.reRenderFileSynchPopup();
		yz.synchFilePopupOverlay.style.display = 'flex';
	};
	self.hideFileSynchPopup = function () {
		self.lastFileSynchPopupFileInfo = false;
		yz.synchFilePopupOverlay.style.display = '';
	};



	
	
	
	self.showFileSynchPopup = function () {
		self.lastFileSynchPopupFileInfo = false;
		var fileInfo = this.fileInfo;
		if(!fileInfo) return;
		self.lastFileSynchPopupFileInfo = fileInfo;
		self.openFileSynchPopup();
	};
	
	
	self.reRenderFileSynchPopup = function () {
		var fName = self.lastFileSynchPopupFileInfo.name;
		var fPath = self.lastFileSynchPopupFileInfo.path;
		yz.headerFileName.innerHTML = yz.serverFileName.innerHTML = fName;
		var fileDownloadHref = location.href + '?ACTION=DOWNLOAD_FILE_CONTENT&';
		fileDownloadHref +='PATH='+fPath;
		yz.serverFilePathLink.href = fileDownloadHref;
		yz.serverFilePathLink.innerHTML = fPath;
	};
	
	
	self.dropFileAreaDragOver = function (e) {
		e.stopPropagation();
		e.preventDefault();
		if(!e || !e.dataTransfer || !e.dataTransfer.types) return;
		if(z_util.inArray('Files', e.dataTransfer.types)){
			yz.dropFileArea.classList.add('dragover');
			yz.dropFileHereText.innerHTML = 'Бросайте!';
		} else {
			yz.dropFileArea.classList.remove('dragover');
			yz.dropFileHereText.innerHTML = 'Перетащите сюда файл';
		}
	};
	
	self.dropFileAreaDragLeave = function (e) {
//		console.log('dropFileAreaDragLeave', this, e);
		if(!z_util.isParentEl(yz.dropFileArea, e.relatedTarget)){
			yz.dropFileArea.classList.remove('dragover');
			yz.dropFileHereText.innerHTML = 'Перетащите сюда файл';
		}
	};
	
	self.dropFileAreaDrop = function (e) {
		yz.dropFileArea.classList.remove('dragover');
		yz.dropFileHereText.innerHTML = 'Перетащите сюда файл';
		if(!e.dataTransfer.files[0]) return;
		var file = e.dataTransfer.files[0];
		self.addFileToActiveSynch(file);
	};
	
	self.consoleLogRecursive = function (obj, key) {
		key = key || '';
		if(typeof obj !== 'object') return;
		for (var i in obj) {
			if(typeof(obj[i]) === 'object'){
				self.consoleLogRecursive(obj[i], key+'_'+i);
			} else {
				console.log(key+'_'+i, obj[i]);
			}
		}
		
		
	};
	
	
	self.onChangeFileInput = function () {
		var file = yz.localFileInput.files[0];
		yz.localFileInput.form.reset();
		if(!file) return;
		self.addFileToActiveSynch(file);
	};
	
	
	self.addFileToActiveSynch = function (file) {
		if(!file || !self.lastFileSynchPopupFileInfo) return;
		var fileInfo = z_util.copyObjDeep(self.lastFileSynchPopupFileInfo);
		self.lastFileSynchPopupFileInfo = false;
		fileInfo.file = file;
		self.hideFileSynchPopup();
		var index = fileInfo.path;
		if(!(index in self.activeFileSynchonizers)){
			self.activeFileSynchonizers[index] = (new FileSynchronizer(fileInfo, self, index));
			if(z_util.getObjLength(self.activeFileSynchonizers) === 1){
				yz.activeSynchWindow.style.display = 'block';
				self.checkInterval = setInterval(self.onCheckIntervalTick, self.checkIntervalMs);
			}
		}
	};

	self.removeFileSynchronizer = function (fileSynchronizer) {
		var index = fileSynchronizer.index;
		if(index in self.activeFileSynchonizers && self.activeFileSynchonizers[index] === fileSynchronizer){
			if (z_util.getObjLength(self.activeFileSynchonizers) === 1) {
				yz.activeSynchWindow.style.display = '';
				clearInterval(self.checkInterval);
			}
			delete self.activeFileSynchonizers[index];
		}
	};
	
	
	self.onCheckIntervalTick = function () {
		for (var i in self.activeFileSynchonizers) {
			if(typeof self.activeFileSynchonizers[i].onCheckIntervalTick === 'function'){
				self.activeFileSynchonizers[i].onCheckIntervalTick();
			}
		}
	};





	
	
	
	
	self.init();
}


function ExplorerApp() {
	var self = this;
	
	self.flags = {
		init: {
			DOM: false,
			ROOT_FOLDER_INFO_LOADED: false,
		},
	};
	
	self.fileSynchCollection = new FileSynchronizerCollection(self);
	
	
	
	self.init = function () {
		document.addEventListener("DOMContentLoaded", self.initDOM);
		self.loadAndTryRenderFolderElements();
	};
	
	self.initDOM = function () {
		self.initHtmlVars();
		self.addDomListeners();
		self.flags.init.DOM = true;
	};
	
	
	self.preventEventDefault = function (e) {
//		console.log(e);
		e.preventDefault();
	};
	
	
	self.addDomListeners = function () {
//		yz.debugFile.addEventListener('change', function (e) {
//
//			var file = z_util.getFirstObjectKeyData(e.target.files);
//			console.log(file);
//			z_util.ajaxSendFile(location.href, file, {'testParam': 'djh87asg8d'}, function (h) {
//				console.log(h);
//			});
//		});

		document.documentElement.addEventListener('drop', self.preventEventDefault);
		document.documentElement.addEventListener('dragover', self.preventEventDefault);
	};
	
	//<editor-fold defaultstate="collapsed" desc="htmlVars">
	
	self.initHtmlVars = function () {
		for (var i in self.htmlVars) {
			if(self.htmlVars[i].type === 'id'){
				var el = document.getElementById(self.htmlVars[i].selector);
				self.htmlVars[i] = el;
			} else if (self.htmlVars[i].type === 'query') {
				el = document.querySelector(self.htmlVars[i].selector);
				self.htmlVars[i] = el;
			} else if (self.htmlVars[i].type === 'queryAll') {
				el = document.querySelectorAll(self.htmlVars[i].selector);
				self.htmlVars[i] = el;
			}
		}
	};
	
	self.htmlVars = {
		'preloader': {type: 'id', selector: 'preloader'},
		'preloader_text': {type: 'id', selector: 'preloader_text'},
		'preloader_image': {type: 'id', selector: 'preloader_image'},
		
		'main': {type: 'id', selector: 'main'},
		'explorer_container': {type: 'id', selector: 'explorer_container'},
		
		'debugFile': {type: 'id', selector: 'debugFile'},
	};
	var yz = self.htmlVars;
	
	//</editor-fold>
	
	
	
	
	self.lastLoadedFolderElements = {};
	self.loadAndTryRenderFolderElements = function (e) {
		var folder = 'ROOT_DIR';
		if(e && e.target && e.target.folderInfo && e.target.folderInfo.path){
			folder = e.target.folderInfo.path;
		}
		try {
			self.showPreloader();
		} catch (e) {
			
		}

		
		self.loadFolderElements(folder, function (d) {
			if(folder === 'ROOT_DIR') {
				self.flags.init.ROOT_FOLDER_INFO_LOADED = true;
			}
			var jsData = z_util.jsonParse(d);
			if(typeof jsData !== 'object'){
				return self.showMessage('Incorrect server response', true);
			}
			if(jsData.ERROR){
				return self.showMessage(jsData.ERROR, true);
			}
			self.hidePreloader();
			self.lastLoadedFolderElements = jsData;
			self.tryRenderFolderElements();
		});
		
		
		
		
	};
	
	
	self.loadFolderElements = function (folder, cb) {
		cb = typeof cb === 'function' ? cb : z_util.doNothing;
		z_util.ajaxPost(location.href, {ACTION: 'GET_FOLDER_INFO', FOLDER: folder}, cb);
	};
	
	
	self.tryRenderFolderElements = function () {
		if(!self.flags.init.DOM || !self.flags.init.ROOT_FOLDER_INFO_LOADED) return;
		if(typeof self.lastLoadedFolderElements !== 'object' || z_util.isObjEmpty(self.lastLoadedFolderElements)) return;
		z_util.clearNodeChildrens(yz.explorer_container);
		yz.explorer_container.appendChild(self.getExplorerHeadTemplate(self.lastLoadedFolderElements));
		for (var i in self.lastLoadedFolderElements.childFolders) {
			yz.explorer_container.appendChild(self.getChildFolderTemplate(self.lastLoadedFolderElements.childFolders[i]));
		}
		for (var i in self.lastLoadedFolderElements.childFiles) {
			yz.explorer_container.appendChild(self.getChildFileTemplate(self.lastLoadedFolderElements.childFiles[i]));
		}
		yz.main.style.display = 'block';
		self.hidePreloader();
		
	};
	
	
	self.getExplorerHeadTemplate = function (elementsInfo) {
		var headDiv = document.createElement('div');
		headDiv.className = 'expl_head';
		if(elementsInfo.parentFolder){
			var parentFolderDiv = document.createElement('div');
			parentFolderDiv.className = 'par_folder';
			parentFolderDiv.folderInfo = elementsInfo.parentFolder;
			parentFolderDiv.onclick = self.loadAndTryRenderFolderElements;
			parentFolderDiv.innerHTML = elementsInfo.parentFolder.name;
			headDiv.appendChild(parentFolderDiv);
		}
		var currentFolderDiv = document.createElement('div');
		currentFolderDiv.className = 'curr_folder';
		currentFolderDiv.folderInfo = elementsInfo.currentFolder;
		currentFolderDiv.onclick = self.loadAndTryRenderFolderElements;
		currentFolderDiv.innerHTML = elementsInfo.currentFolder.name;
		headDiv.appendChild(currentFolderDiv);
		return headDiv;
	};
	
	
	self.getChildFolderTemplate = function (folderInfo) {
		var folderDiv = document.createElement('div');
		folderDiv.className = 'expl_folder';
		folderDiv.folderInfo = folderInfo;
		folderDiv.onclick = self.loadAndTryRenderFolderElements;
		folderDiv.innerHTML = folderInfo.name;
		return folderDiv;
	};
	
	self.getChildFileTemplate = function (fileInfo) {
		var fileDiv = document.createElement('div');
		fileDiv.className = 'expl_file';
		fileDiv.fileInfo = fileInfo;
		if(fileInfo.href){
			var link = document.createElement('a');
			link.target = '_blank';
			link.href = fileInfo.href;
			link.innerHTML = fileInfo.name;
			fileDiv.appendChild(link);
		} else {
			fileDiv.innerHTML = fileInfo.name;
		}
		fileDiv.appendChild(self.getSynchFileIconTemplate(fileInfo));
//		fileDiv.onclick = self.loadAndTryRenderFolderElements;
		return fileDiv;
	};
	
	
	self.getSynchFileIconTemplate = function (fileInfo) {
		var div = document.createElement('div');
		div.className = 'fileSynchIcon';
		div.fileInfo = fileInfo;
		div.innerHTML = '<svg width="27" height="31"><use xlink:href="#fileSynchIcon"></use></svg>';
		div.onclick = self.fileSynchCollection.showFileSynchPopup;
		return div;
	};
	
	
	
	
	//<editor-fold defaultstate="collapsed" desc="preloader">
	
	self.hidePreloader = function () {
		yz.preloader.style.display = 'none';
		document.body.style.overflow = '';
	};
	self.showPreloader = function (text, notTransparent, hideIcon, hideOnClick, fontSize) {
		if (text) {
			yz.preloader_text.innerHTML = text;
		} else {
			//			yz.preloader_text.innerHTML = '';
		}
		if (notTransparent) {
			yz.preloader.style.backgroundColor = '#fff';
		} else {
			yz.preloader.style.backgroundColor = '';
		}
		if (hideIcon) {
			yz.preloader_image.style.display = 'none';
		} else {
			yz.preloader_image.style.display = '';
		}
		if (hideOnClick) {
			yz.preloader.onclick = self.hidePreloader;
		} else {
			yz.preloader.onclick = null;
		}
		if (fontSize) {
			yz.preloader_text.style.fontSize = fontSize;
		} else {
			yz.preloader_text.style.fontSize = '';
		}
//		document.body.style.overflow = 'hidden';
		yz.preloader.style.display = '';
		//		yz.preloader.style.height = '';
		//		if(yz.preloader.clientHeight < document.body.scrollHeight){
		//			yz.preloader.style.height = document.body.scrollHeight + 'px';
		//		}
	};
	self.showMessage = function (messages, fatal) {
		var str = '';
		if (typeof messages === 'string') {
			str = messages;
		} else if (typeof messages === 'object') {
			for (var i in messages) {
				if (typeof messages[i] !== 'string')
					continue;
				str += messages[i] + '<br>';
			}
		}
		var notTransparent = !!fatal;
		var hideOnClick = !fatal;
		var fontSize = '';
		if (str.length !== 0) {
			if (str.length > 50)
				fontSize = '2em';
			if (str.length > 200)
				fontSize = '1em';
			self.showPreloader(str, notTransparent, 1, hideOnClick, fontSize);
		}
	};
	//</editor-fold>

	
	




	self.init();
}


var app = new ExplorerApp;