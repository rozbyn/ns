
var m3uUrl = '';
var parts = {};
var partsCount = 0;
var currPartsCount = 0;


function downloadTrackByID(trackFullID) {
	var trackAr = getTrackArrByID(trackFullID);
	if(trackAr === false) return false;
	if(trackAr[2] === ''){
		window.ap._ensureHasURL(trackAr, function (trackAr) {
			processDownloadTrack(trackAr[2]);
		});
	} else {
		processDownloadTrack(trackAr[2]);
	}
}

function getTrackArrByID(trackFullID) {
	var index = ap._currentPlaylist._ref._list.findIndex(function(el){
		if((el[1] + '_' + el[0]) === trackFullID) return true;
	});
	if(index === -1) return false;
	return ap._currentPlaylist._ref._list[index];
}



function processDownloadTrack(urlWithExtra) {
	m3uUrl = getm3u8Url(urlWithExtra);
	ajaxPost(m3uUrl, {}, downloadAllParts);
}



function downloadAllParts(responce) {
	console.log(responce);
	parts = getArUrlsOfTrack(ab2str(responce));
	for (var i in parts) {
		ajaxPost(i, {}, savePartData.bind(null, i));
	}
}

function ab2str(buf) {
  return String.fromCharCode.apply(null, new Uint8Array(buf));
}



function savePartData(partUrl, responce) {
	parts[partUrl] = responce;
	console.log(responce);
	currPartsCount++;
	if(currPartsCount === partsCount){
		process2DownloadTrack();
	}
}



function process2DownloadTrack() {
	var dataStr = '';
	for (var i in parts) {
		dataStr += parts[i];
	}
	// dataStr - полная хуйня, не mp3 а поебень
	// походу эти куски трека закодированы в какое-то говно
	// 
	// ap._impl._currentHls.coreComponents[4].onSBUpdateEnd() 8647
	// 
	// 
//	saveFile(dataStr);
}


function saveFile(data) {
	var file = new File([data], 'asdasd.mp3');
	var a = document.createElement('a');
	var d = URL.createObjectURL(file);
	a.download = 'asdasd.mp3';
	a.href = d;
	a.click();
}


function getArUrlsOfTrack(indexm3u8data) {
	var reg = /^#EXTINF:.*$\n(^.*)$/igm;
	var urlFirstPart = m3uUrl.split('index.m3u8?extra=')[0];
	var regRes, arUrls = {};
	while ((regRes = reg.exec(indexm3u8data))) {
		partsCount++;
		arUrls[urlFirstPart+regRes[1]] = '';
	}
	return arUrls;
}



(function () {
	var r = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN0PQRSTUVWXYZO123456789+/=";
	var n = {
			v: function(t) {
					return t.split("").reverse().join("")
			},
			r: function(t, e) {
					t = t.split("");
					for (var i, n = r + r, o = t.length; o--; )
							~(i = n.indexOf(t[o])) && (t[o] = n.substr(i - e, 1));
					return t.join("")
			},
			s: function(t, e) {
					var i = t.length;
					if (i) {
							var r = function(t, e) {
									var i = t.length
										, r = [];
									if (i) {
											var n = i;
											for (e = Math.abs(e); n--; )
													e = (i * (n + 1) ^ e + n) % i,
													r[n] = e
									}
									return r
							}(t, e)
								, n = 0;
							for (t = t.split(""); ++n < i; )
									t[n] = t.splice(r[i - 1 - n], 1, t[n])[0];
							t = t.join("")
					}
					return t
			},
			i: function(t, e) {
					return n.s(t, e ^ vk.id)
			},
			x: function(t, e) {
					var i = [];
					return e = e.charCodeAt(0),
					each(t.split(""), function(t, r) {
							i.push(String.fromCharCode(r.charCodeAt(0) ^ e))
					}),
					i.join("")
			}
	};
	function a(t) {
			if (!t || t.length % 4 == 1)
					return !1;
			for (var e, i, n = 0, o = 0, a = ""; i = t.charAt(o++); )
					~(i = r.indexOf(i)) && (e = n % 4 ? 64 * e + i : i,
					n++ % 4) && (a += String.fromCharCode(255 & e >> (-2 * n & 6)));
			return a
	}
	function o(t) {
			if ((!window.wbopen || !~(window.open + "").indexOf("wbopen")) && ~t.indexOf("audio_api_unavailable")) {
					var e = t.split("?extra=")[1].split("#")
						, i = "" === e[1] ? "" : a(e[1]);
					if (e = a(e[0]),
					"string" != typeof i || !e)
							return t;
					for (var r, o, s = (i = i ? i.split(String.fromCharCode(9)) : []).length; s--; ) {
							if (r = (o = i[s].split(String.fromCharCode(11))).splice(0, 1, e)[0],
							!n[r])
									return t;
							e = n[r].apply(null, o)
					}
					if (e && "http" === e.substr(0, 4))
							return e
			}
			return t
	}
	window.getm3u8Url = o;
})();


function ajaxPost(url, params, callback){
	function encodeObj (obj){
		var query = Object.keys(obj)
				.map(function (k){
					return encodeURIComponent(k) + '=' + encodeURIComponent(obj[k]);
				})
				.join('&');
		return query;
	}
	function isObjEmpty (obj) {
		for (var k in obj) return false;
		return true;
	};
	var method = 'GET';
	if(isObjEmpty(params)) {
		params = '';
	} else {
		params = encodeObj(params);
		method = 'POST';
	}
	var request = new XMLHttpRequest();
	request.responseType = 'arraybuffer';
	var f = callback || function(){};
	request.onreadystatechange = function(){
		if (request.readyState === 4 && request.status === 200){
			f(request.response);
		} 
	};
	request.open(method, url);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	request.send(params);
}