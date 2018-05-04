<?php 
if(!function_exists('virtual')){
	//echo 'VIRTUAL!' . '<br>';
	function virtual ($uri, $host = false) {
		$host = $host ?: $_SERVER['HTTP_HOST'];
		$url = "http://$host$uri";
		//echo $url . '<br>';
		echo file_get_contents($url);
	}
}
virtual('', 'ya.ru');