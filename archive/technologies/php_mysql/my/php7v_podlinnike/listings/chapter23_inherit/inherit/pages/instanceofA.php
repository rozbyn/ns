<?php ## Оператор instanceof.
  require_once "StaticPageA.php";
  function echoPage($obj)
  {
    $class = "Page";
    if (!($obj instanceof $class)) 
      die("Argument 1 must be an instance of $class.<br />");
    $obj->render();
  }
  $page = new StaticPage(3);
  echoPage($page);
  //echo $page->id(6) . '<br>';
?>