/* global vk */


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