<?php ## Вывод за исключением PHP-файлов.
  require_once("lib/filter.php");
echo  '<pre>';
  $filter = new ExtensionFilter(
                  new DDirectoryIterator('.'),
                  'php'
                );

  foreach($filter as $file) {
    echo $file."<br />";
  }
?>