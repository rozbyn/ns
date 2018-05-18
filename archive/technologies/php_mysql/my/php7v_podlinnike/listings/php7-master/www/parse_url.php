<?php ## Пример разбора URL.
  //$url = "https://rozb:a314@host.com:80/path?arg=value#anchor";
  $url = "http://example.com/path/path?yigo[]=10238&yigo[]=das#asdgvb";
  echo "<pre>"; print_r(parse_url($url)); echo "</pre>";
?>