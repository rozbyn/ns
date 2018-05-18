<?php ## Рекурсивный обход каталога при помощи итераторов
  $dir = new RecursiveIteratorIterator(
           new RecursiveDirectoryIterator('.'),
         true);
echo  '<pre>';
  foreach ($dir as $file)
  {
    echo str_repeat("	", $dir->getDepth())." $file<br />";
  }
?>