<?php
	
	$a = mt_rand(-10, 10);
	$b = mt_rand(-10, 10);
	
	if($a > $b){	
		echo "$a > $b";
	}
	elseif($a < $b){
		echo "$a < $b";
	}
	else{
		echo "$a = $b";
	}
