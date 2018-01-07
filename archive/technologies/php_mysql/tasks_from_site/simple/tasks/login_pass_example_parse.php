<pre>
<style>
	* {margin:0;padding:0}
	div {
		float:left;
		margin:5px;
		padding:5px;
		border: 1px solid black;
	}
</style>
<?php
echo '<div>';
/*--------------------------------------------------*/
$arrr = ['rozbyn:awdsawds', 'kera:fgdfgdfgd'];



foreach ($arrr as $lap){
	$a = strpos($lap,':');
	$login = substr($lap, 0, $a);
	$pass = substr($lap, $a+1);
	echo $login . '<br>';
	echo $pass . '<br>';
	echo '<br>';
}


















echo '</div>' . '<br>';
?>
</pre>
