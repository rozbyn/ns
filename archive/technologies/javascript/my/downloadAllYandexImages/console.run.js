
(function () {
	var aArr = [];
	var imagesList = document.querySelectorAll('.serp-item[role="listitem"]');
	for (var i = 0; i < imagesList.length; i++) {
		try {
			var imageInfo = JSON.parse(imagesList[i].getAttribute('data-bem'));
		} catch (e) {}
		if(!imageInfo) continue;
		console.log(imageInfo['serp-item'].img_href);
		var a = document.createElement('a');
		a.target = '_blank';
		a.download = 'bob';
		a.href = imageInfo['serp-item'].img_href;
		a.style.display = 'none';
		document.body.appendChild(a);
		a.click();
		aArr.push(a);
	}
})();
