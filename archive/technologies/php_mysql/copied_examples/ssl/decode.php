<?php
$key = <<<SOMEDATA777
-----BEGIN RSA PRIVATE KEY-----
MIIBPQIBAAJBALqbHeRLCyOdykC5SDLqI49ArYGYG1mqaH9/GnWjGavZM02fos4l
c2w6tCchcUBNtJvGqKwhC5JEnx3RYoSX2ucCAwEAAQJBAKn6O+tFFDt4MtBsNcDz
GDsYDjQbCubNW+yvKbn4PJ0UZoEebwmvH1ouKaUuacJcsiQkKzTHleu4krYGUGO1
mEECIQD0dUhj71vb1rN1pmTOhQOGB9GN1mygcxaIFOWW8znLRwIhAMNqlfLijUs6
rY+h1pJa/3Fh1HTSOCCCCWA0NRFnMANhAiEAwddKGqxPO6goz26s2rHQlHQYr47K
vgPkZu2jDCo7trsCIQC/PSfRsnSkEqCX18GtKPCjfSH10WSsK5YRWAY3KcyLAQIh
AL70wdUu5jMm2ex5cZGkZLRB50yE6rBiHCd5W1WdTFoe
-----END RSA PRIVATE KEY-----
SOMEDATA777;
$data = file_get_contents('data.txt');
$data2 = file_get_contents('data2.txt');
$pk  = openssl_get_privatekey($key);
openssl_private_decrypt(base64_decode($data), $out, $pk);
openssl_private_decrypt($data2, $out2, $pk);
echo $out . '<br>';
echo $out2 . '<br>';
?>