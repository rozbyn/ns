



const maximumTwo = (arr) => {
    let max1 = arr[0];
    let max2 = arr[1];
    let max1I = 0;
    let max2I = 1;
    for(let i = 2; i < arr.length; i++) {
        if (arr[i] > max1) {
            if (max1 > max2) {
                max2 = arr[i];
                max2I = i;
            } else {
                max1 = arr[i];
                max1I = i;
            }
        } else if (arr[i] > max2) {
            max2 = arr[i];
            max2I = i;
        }
    }

    if (max1 > max2) return [max2, max1, max2I, max1I];
    return [max1, max2, max1I, max2I];
};
const findLatestWeightBetter = function(weights) {
    if (weights.length <= 1) {
        return weights[0];
    }

    do {
        const [x, y, xI, yI] =  maximumTwo(weights);
        if (x === 0) {
            return y;
        }

        weights[xI] = 0;
        weights[yI] = y - x;

    } while(true);
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



const { PerformanceObserver, performance } = require('perf_hooks');

var testFuncPerformanceMultiple = function (func, args, times = 1) {
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





var bigArray = getArray(100000);


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
