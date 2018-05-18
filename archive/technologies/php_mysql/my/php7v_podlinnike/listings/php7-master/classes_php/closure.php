<?php ## Захваченные замыканием переменные хранятся в объекте Closure.
  $message = "Работа не может быть продолжена из-за ошибок:<br />";
  $check = function(array $errors) use ($message) {
    if (isset($errors) && count($errors) > 0) {
      echo $message;
      foreach($errors as $error) {
        echo "$error<br />";
      }
    }
  };
$as = function ($a) use ($message) {
	echo $message . ' : ' . $a . '<br>';
};
  echo "<pre>";
  print_r($check);
  echo "</pre>";
?>