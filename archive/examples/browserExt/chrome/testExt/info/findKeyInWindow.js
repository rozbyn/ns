

(function () {
	
	var pathDivider = ' ==> ';
	var excludePaths = [
		'window' + pathDivider + 'ap',
		'window' + pathDivider + 'Emoji',
		'window' + pathDivider + 'curFastChat',
		'window' + pathDivider + 'vkCache',
		'window' + pathDivider + 'emojiStickers',
		'window' + pathDivider + 'navigator',
		'window' + pathDivider + 'clientInformation',
		'window' + pathDivider + 'chrome',
		'window' + pathDivider + 'ajaxCache',
	];
	var stopSearching = false;
	

	function getNextKey(obj, currKey) {
		var nextKeyReturn = false;
		for (var i in obj) {
			if(nextKeyReturn) return i;
			if(i == currKey) nextKeyReturn = true;
		}
		return false;
	}



	function getObjectByPath(path) {
		if(typeof path !== 'string') return false;
		var parts = path.split(pathDivider);
		var currObj = window;
		var returnFalse = false;
		parts.forEach(function (pathPart) {
			if(isNormalObject(currObj) && pathPart in currObj){
				currObj = currObj[pathPart];
			} else {
				returnFalse = true;
			}
		});
		return returnFalse?false:currObj;
	}


	function getNextKeyPath(path) {
		if(typeof path !== 'string') return false;
		var pPath = getParentPath(path);
		var pObj = getObjectByPath(pPath);
		var cKey = getCurrentKeyByPath(path);
		var nKey = getNextKey(pObj, cKey);
		if(nKey){
			return pPath + pathDivider + nKey;
		}
		return false;
	}


	function getCurrentKeyByPath(path) {
		if(typeof path !== 'string') return false;
		return path.split(pathDivider).pop();
	}


	function getParentPath(path) {
		if(typeof path !== 'string') return false;
		var parts = path.split(pathDivider);
		if(parts.length == 1) return false;
		parts.pop();
		return parts.join(pathDivider);
	}



	function isKeyInObject(key, object) {
		if(isNormalObject(object)){
			return key in object;
		}
		return false;
	}
	
	
	function isNormalObject(object) {
		try {
			if (object && typeof object === 'object' && !('nodeName' in object)) {
				return true;
			}			
		} catch (e) {}
		return false;
	}
	
	
	function getFirstKey(currPath, obj) {
		if(obj === window && currPath !== 'window') return false;
		if(excludePaths.indexOf(currPath) !== -1) return false;
		if(isNormalObject(obj)){
			for (var i in obj) {
				return i;
			}
		}
		return false;
	}
	

	
	
	var loggin = true;
	function logAction() {
		if(loggin){
			console.log.apply(this, arguments);
		}
	}
	
	

	
	function stopSearchingKey() {
		stopSearching = true;
	}
	
	function findKeyInObj(key, objectPath, depth) {
		depth = (parseInt(depth) > 0) ? depth : 0;
		var currDepthLevel = 0;
		var currPath = objectPath;
		var resultPaths = [];
		for(var cco = 0; cco < 1000000000; cco++){
			
			
			if(stopSearching) {
				stopSearching = false;
				return resultPaths;
			}
			
			var currObj = getObjectByPath(currPath);
			if(isNormalObject(currObj)){
				if (isKeyInObject(key, currObj)) {
					resultPaths.push(currPath + pathDivider + key);
				}
			};
			
			
			var pPath = getParentPath(currPath);
			var nPath = getNextKeyPath(currPath);
			var fKey = getFirstKey(currPath ,currObj);
//				console.log(pPath, nPath, fKey);

			if(fKey && (currDepthLevel+1) <= depth){
				currPath += pathDivider+fKey;
				currDepthLevel++;
				logAction(currDepthLevel, '++DepthLevel', currPath);

			} else if (nPath){
				currPath = nPath;
				logAction(currDepthLevel, 'next', currPath);

			} else if (pPath){
				parNKey = false;
				while (currDepthLevel > 0) {
					var parNKey = getNextKeyPath(pPath);
//						console.log(currDepthLevel, parNKey, pPath);
					if(!parNKey) {
						pPath = getParentPath(pPath);
						currDepthLevel--;
					} else {
						currPath = parNKey;
						currDepthLevel--;
						break;
					}
				}
				if(!parNKey) {
					logAction(currDepthLevel, '!parNKey');
					return resultPaths;
				} else {
					logAction(currDepthLevel, '--DepthLevel parentNKey', currPath);

				}
			} else {
				logAction('???');
				return resultPaths;
			}
		}
		
		
	}
	var testObject = {
		"web-app": {
			"servlet": [
				{
					"servlet-name": "cofaxCDS",
					"servlet-class": "org.cofax.cds.CDSServlet",
					"init-param": {
						"configGlossary:installationAt": "Philadelphia, PA",
						"configGlossary:adminEmail": "ksm@pobox.com",
						"configGlossary:poweredBy": "Cofax",
						"configGlossary:poweredByIcon": "/images/cofax.gif",
						"configGlossary:staticPath": "/content/static",
						"templateProcessorClass": "org.cofax.WysiwygTemplate",
						"templateLoaderClass": "org.cofax.FilesTemplateLoader",
						"templatePath": "templates",
						"templateOverridePath": "",
						"defaultListTemplate": "listTemplate.htm",
						"defaultFileTemplate": "articleTemplate.htm",
						"useJSP": false,
						"jspListTemplate": "listTemplate.jsp",
						"jspFileTemplate": "articleTemplate.jsp",
						"cachePackageTagsTrack": 200,
						"cachePackageTagsStore": 200,
						"cachePackageTagsRefresh": 60,
						"cacheTemplatesTrack": 100,
						"cacheTemplatesStore": 50,
						"cacheTemplatesRefresh": 15,
						"cachePagesTrack": 200,
						"cachePagesStore": 100,
						"cachePagesRefresh": 10,
						"cachePagesDirtyRead": 10,
						"searchEngineListTemplate": "forSearchEnginesList.htm",
						"searchEngineFileTemplate": "forSearchEngines.htm",
						"searchEngineRobotsDb": "WEB-INF/robots.db",
						"useDataStore": true,
						"dataStoreClass": "org.cofax.SqlDataStore",
						"redirectionClass": "org.cofax.SqlRedirection",
						"dataStoreName": "cofax",
						"dataStoreDriver": "com.microsoft.jdbc.sqlserver.SQLServerDriver",
						"dataStoreUrl": "jdbc:microsoft:sqlserver://LOCALHOST:1433;DatabaseName=goon",
						"dataStoreUser": "sa",
						"dataStorePassword": "dataStoreTestQuery",
						"dataStoreTestQuery": "SET NOCOUNT ON;select test='test';",
						"dataStoreLogFile": "/usr/local/tomcat/logs/datastore.log",
						"dataStoreInitConns": 10,
						"dataStoreMaxConns": 100,
						"dataStoreConnUsageLimit": 100,
						"dataStoreLogLevel": "debug",
						"maxUrlLength": 500
					}
				},
				{
					"servlet-name": "cofaxEmail",
					"servlet-class": "org.cofax.cds.EmailServlet",
					"init-param": {
						"mailHost": "mail1",
						"mailHostOverride": "mail2"
					}
				},
				{
					"servlet-name": "cofaxAdmin",
					"servlet-class": "org.cofax.cds.AdminServlet"},

				{
					"servlet-name": "fileServlet",
					"servlet-class": "org.cofax.cds.FileServlet"},
				{
					"servlet-name": "cofaxTools",
					"servlet-class": "org.cofax.cms.CofaxToolsServlet",
					"init-param": {
						"templatePath": "toolstemplates/",
						"log": 1,
						"logLocation": "/usr/local/tomcat/logs/CofaxTools.log",
						"logMaxSize": "",
						"dataLog": 1,
						"dataLogLocation": "/usr/local/tomcat/logs/dataLog.log",
						"dataLogMaxSize": "",
						"removePageCache": "/content/admin/remove?cache=pages&id=",
						"removeTemplateCache": "/content/admin/remove?cache=templates&id=",
						"fileTransferFolder": "/usr/local/tomcat/webapps/content/fileTransferFolder",
						"lookInContext": 1,
						"adminGroupID": 4,
						"betaServer": true
					}
				}
			],
			"servlet-mapping": {
				"cofaxCDS": "/",
				"cofaxEmail": "/cofaxutil/aemail/*",
				"cofaxAdmin": "/admin/*",
				"fileServlet": "/static/*",
				"cofaxTools": "/tools/*"},

			"taglib": {
				"taglib-uri": "cofax.tld",
				"taglib-location": "/WEB-INF/tlds/cofax.tld"}
		}
	};
	window.testObject = testObject;
//	console.log(findKeyInObj('cofaxEmail', 'testObject', 6));
	window.findKeyInObj = findKeyInObj;
	window.stopSearchingKey = stopSearchingKey;

})();



//getCurrentBuffered
//window.ap._impl._currentHls.coreComponents[4].pendingTracks