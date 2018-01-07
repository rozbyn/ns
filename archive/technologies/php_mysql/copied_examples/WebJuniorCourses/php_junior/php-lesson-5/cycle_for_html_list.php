<?php
	
	$towns = [
		'Россия' => ['Москва', 'Сочи', 'Питер'], 
		'Франция' => ['Париж', 'Марсель', 'Ницца'], 
		'Англия' => ['Лондон', 'Манчестер'], 
		'Япония' => ['Токио']
	];
	
	echo '<ul>';
	
	foreach($towns as $country => $cities){
		echo "<li>$country<ol>";
		
		for($i = 0; $i < count($cities); $i++){
			echo '<li>' . $cities[$i] . '</li>';
		}
		
		echo "</ol></li>";
	}

	echo '</ul>';
	
	/*
		ul-li-ol-li
					
		<ul>внешний цикл</ul>	

		<ul>
			<li>country
				<ol>
					<li>1</li>
					<li>2</li>
				</ol>
			</li>
			<li>country
				<ol>
					<li>1</li>
					<li>2</li>
				</ol>
			</li>
		</ul>
	*/
