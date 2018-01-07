<?php
	
	$a = mt_rand(-10, 10);
	$b = mt_rand(-10, 10);
	
	if($a > 0 || $b > 0){	
		echo ($a > $b) ? $a : $b;
	}
	else{
		echo "$a $b пас";
	}
	
	/* 
		$res = ($a > $b) ? $a : $b;
	*/
	
	/*
		не надо
		echo ($a > 0 || $b > 0) ? (($a > $b) ? $a : $b) : "$a $b пас"; 
	*/
	
