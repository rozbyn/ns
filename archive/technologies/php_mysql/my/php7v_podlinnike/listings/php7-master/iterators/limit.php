<?php ## Использование класса LimitIterator
  require_once("lib/filter.php");
echo  '<pre>';
  $limit =  new LimitIterator(
              new ExtensionFilter(new DirectoryIterator('.'), "php"),
              0, 2);

  foreach($limit as $file) {
    echo $file."<br />";
  }
?>