<?php
$pub = <<<SOMEDATA777
-----BEGIN PUBLIC KEY-----
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBALqbHeRLCyOdykC5SDLqI49ArYGYG1mq
aH9/GnWjGavZM02fos4lc2w6tCchcUBNtJvGqKwhC5JEnx3RYoSX2ucCAwEAAQ==
-----END PUBLIC KEY-----
SOMEDATA777;
$data = <<<SOMEDATA777
Lorem ipsum dolor sit amet, csadasagghghjffghghjgj
SOMEDATA777;
$pk  = openssl_get_publickey($pub);
openssl_public_encrypt($data, $encrypted, $pk);
$encData = chunk_split(base64_encode($encrypted));
file_put_contents('data.txt', $encData);
file_put_contents('data2.txt', $encrypted);
echo $encData;
?>

<style>
	body{
		font-family: monospace;
	}
</style>
