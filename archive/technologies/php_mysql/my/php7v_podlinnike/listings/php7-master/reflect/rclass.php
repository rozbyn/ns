<?php ## Отражение класса.
  require_once('lib/Complex2.php');
  $className = 'MathComplex2';
  $args = [1,2];
  $class = new ReflectionClass($className);
  //$obj = call_user_func_array([$class, 'newInstance'], $args);
  echo "<pre>", $class, "</pre>";
?>