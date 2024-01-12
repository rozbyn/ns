var module = {
	exports: 1
};



module.exports = function(str) {
	var uniqCount = 0;
	var uniqChars = {};
	var uniqArr = [];
	var firstChar = false;
	var matches = [...str.matchAll(/[^a-z]+/g)];
	matches.forEach(function (el, i) {
		if (i === 0) {
			firstChar = el[0];
		}
		if (el[0] in uniqChars){
			uniqChars[el[0]].positions.push(el.index);
		} else {
			var obj = {char: el[0], positions: [el.index]};
			uniqCount++;
			uniqChars[el[0]] = obj;
			uniqArr.push(obj);
		}
	});
	if (uniqCount == 1) {
		return {mod: firstChar};
	}
	uniqArr.sort(function (el1, el2) {
		return el2.positions.length - el1.positions.length;
	});
	if (uniqArr[0].positions.length === uniqArr[1].positions.length) {
		return uniqArr[0].positions[0] > uniqArr[1].positions[0] ? 
								{mod: uniqArr[1].char, elem: uniqArr[0].char}: 
								{mod: uniqArr[0].char, elem: uniqArr[1].char};
	} else {
		return {mod: uniqArr[0].char, elem: uniqArr[1].char};
	}
};

var examples = [
	'block__mod__val—elem', 
	'block–mod–val___elem', 
	'block_mod__elem',
	'block_mod_mod__elem',
	'block__elem_mod_mod',
];

for (var i = 0; i < examples.length; i++) {
	var r = module.exports(examples[i]);
	console.log(examples[i], r);
}

