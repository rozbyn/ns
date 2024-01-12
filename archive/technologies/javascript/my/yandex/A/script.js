




var findLatestWeightBetter = function(weights) {
	if (weights.length <= 1) return weights[0];
	var  findTwoLargest = function (weights) {
		var num1 = weights[0];
		var num2 = weights[1];
		var num1idx = 0;
		var num2idx = 1;
		for (var i = 2; i < weights.length; i++) {
			if (weights[i] > num1) {
				if (num1 > num2) {
					num2 = weights[i];
					num2idx = i;
				} else {
					num1 = weights[i];
					num1idx = i;
				}
			} else {
				if (weights[i] > num2) {
					num2 = weights[i];
					num2idx = i;
				}
			}
		}
		
		if (num1 > num2) return [num2, num1, num2idx, num1idx];
		return [num1, num2, num1idx, num2idx];
	};
	do {
		const [x, y, xI, yI] = findTwoLargest(weights);
		if (x === 0) {
			return y;
		}
		weights[xI] = 0;
		weights[yI] = y - x;

	} while (true);
};




var findLatestWeight = function(weights) {
	if (weights.length === 0) return 0;
	if (weights.length === 1) return weights[0];
	weights.sort((a, b) => a - b);
	while (weights.length > 1) {
		var largestNumber1 = weights.pop();
		var largestNumber2 = weights.pop();
		var diff = largestNumber1 - largestNumber2;
		if (diff !== 0) {
			var idx = weights.findIndex( (x) => (x >= diff) );
			if (idx === -1) {
				weights.push(diff);
			} else {
				weights.splice(idx, 0, diff);
			}
		}
	}
	return weights.length === 1 ? weights[0] : 0;
};







var getArray = function (length) {
//	return Array.from({length: length}, (v, i) => i);
	return Array.from({length: length}, (v, i) => Math.floor(Math.random() * length));
};


var jsonClone = function (param) {
	return JSON.parse(JSON.stringify(param));
};




var testFuncPerformance = function (func, args) {
	var t1 = performance.now();
	var funcRes = func.apply(null, args);
	var t2 = performance.now();
	console.log(t2 - t1);
	return t2 - t1;
};





var testFuncPerformanceMultiple = function (func, args, times = 1000) {
	var argsCopy = jsonClone(args);
	var t1 = performance.now();
	for (var i = 0; i < times; i++) {
		var r = func.apply(null, argsCopy);
//		console.log(args);
	}
	var t2 = performance.now();
	var totalTime = t2 - t1;
	return totalTime + ' / ' + times;
};





var bigArray = getArray(10000);


var averageTime1 = testFuncPerformanceMultiple(findLatestWeightBetter, [bigArray]);
var averageTime2 = testFuncPerformanceMultiple(findLatestWeight, [bigArray]);
var averageTime3 = testFuncPerformanceMultiple(findLatestWeightBetter, [bigArray]);
var averageTime4 = testFuncPerformanceMultiple(findLatestWeight, [bigArray]);
var averageTime5 = testFuncPerformanceMultiple(findLatestWeightBetter, [bigArray]);
var averageTime6 = testFuncPerformanceMultiple(findLatestWeight, [bigArray]);
console.log(
		'\navTime1:', averageTime1, 
		'\navTime2:', averageTime2, 
		'\n\navTime3:', averageTime3, 
		'\navTime4:', averageTime4, 
		'\n\navTime5:', averageTime5, 
		'\navTime6:', averageTime6
);
