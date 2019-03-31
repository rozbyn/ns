
var input = document.getElementById('input');
input.addEventListener('input', handle);

function handle(e) {
	var r = {};
	var ar = this.value.split('');
	ar.forEach(function (v) {
		if(!(v in r)){
			r[v] = 1;
		} else {
			r[v]++;
		}
	});
	console.log(r);
}






