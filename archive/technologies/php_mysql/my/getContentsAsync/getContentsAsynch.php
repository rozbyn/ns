<?php
function getContentsAsync($arrOfUrls) {
	$multi = curl_multi_init();
	$channels = array();
	foreach ($arrOfUrls as $url) {
    $ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_ENCODING, "");
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_multi_add_handle($multi, $ch);
    $channels[$url] = $ch;
	}
	$active = null;
	$i = $j = $k = $m = 0;
	// var_dump('CURLM_CALL_MULTI_PERFORM:', CURLM_CALL_MULTI_PERFORM);
	// var_dump('CURLM_OK:', CURLM_OK);
	do {
		$i++;
		$mrc = curl_multi_exec($multi, $active);
		// echo ("iteration \$i: $i, \$active:$active, \$mrc:$mrc \r\n");
	} while ($mrc == CURLM_CALL_MULTI_PERFORM && $i < 100);
	
	while ($active && $mrc == CURLM_OK && $j < 1000) {
		$j++;
		// echo ("iteration \$j: $j, \$active:$active, \$mrc:$mrc \r\n");
		if (curl_multi_select($multi) == -1) usleep(1);
		do {
			$k++;
			$mrc = curl_multi_exec($multi, $active);
			// echo ("iteration \$k: $k, \$active:$active, \$mrc:$mrc \r\n");
		} while ($mrc == CURLM_CALL_MULTI_PERFORM  && $k < 1000);
	}
	$result = [];
	foreach ($channels as $url => $channel) {
		$m++;
		$result[$url]['content'] = curl_multi_getcontent($channel);
		$result[$url]['err'] = curl_errno($channel);
		$result[$url]['errmsg'] = curl_error($channel);
		$result[$url]['header'] = curl_getinfo($channel);
		curl_multi_remove_handle($multi, $channel);
	}
	curl_multi_close($multi);
	return $result;
}