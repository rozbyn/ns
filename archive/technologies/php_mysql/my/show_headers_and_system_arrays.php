

<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
echo '<pre>' . '<br>';
print_r($_GET);
print_r($_POST);
print_r($_REQUEST);
print_r($_SERVER);
$headers = apache_request_headers();
if (isset($headers['Referer'])){
	echo $headers['Referer'] . '<br>';
}


foreach ($headers as $header => $value) {
    echo "$header: $value <br />\n";
}
echo '</pre>' . '<br>';
?>

