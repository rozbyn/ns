window.onload = function(){
	
	function checkFields (e){
		e.preventDefault();
		$this = $(this);
		isValid = Inputmask.isValid(this[0].value, 'email');
		if(isValid){
			$this.off('submit');
			$this.submit();
		}
	}
	
	$test = $("#test");
	$('#test_form').on('submit', checkFields);
	
	$asad = $test.inputmask({
		mask: "*{1,64}[.*{1,64}][.*{1,64}][.*{1,63}]@-{1,63}.-{1,63}[.-{1,63}][.-{1,63}]",
		greedy: !1,
		casing: "lower",
		definitions: {
			"*": {
				validator: "[0-9１-９A-Za-zА-яЁёÀ-ÿµ!#$%&'*+/=?^_`{|}~-]"
			},
			"-": {
				validator: "[0-9A-Za-z-]"
			}
		},
		"oncomplete": function(){ 
			$(this).css({"background":"#d6ffd6", "border":"1px solid #0dd500"});
		},
		"onincomplete": function(){ 
			$(this).css({"background":"#ffb9b9", "border":"1px solid #ea0000"});
		},
		
		
	});
	console.log($asad);
}