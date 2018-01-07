<?php
	
	$list = scandir('data');
	
	foreach($list as $fname){
		if(is_file("data/$fname")){
			echo "<a href=\"post.php?id=$fname\">Новость $fname</a><br>";
		}
	}