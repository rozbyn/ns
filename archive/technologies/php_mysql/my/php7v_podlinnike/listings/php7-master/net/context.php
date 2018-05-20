<?php ## Использование контекста потока.
  $opts = [
    'http' => [
      'method' => 'GET',
      'user_agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:42.0)',
      'header' => 'Host: rozbyn.esy.es
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: en-GB,en;q=0.5
Accept-Encoding: gzip, deflate
Cookie: dlJniPaZps=Njk5HhpI4u
DNT: 1
Connection: keep-alive
Upgrade-Insecure-Requests: 1'
    ]
  ];

  echo file_get_contents(
    'http://rozbyn.esy.es/ns2/download.php',
    false,
    stream_context_create($opts)
  );
?>