<?php
echo '<pre>';
  echo file_get_contents('file:///etc/hosts');
  //echo file_get_contents('file:///C:/Windows/system32/drivers/etc/hosts');

  file_put_contents("ftp://u784337761:vWJG3oCVBK@ftp.rozbyn.esy.es/f.txt", "This is my world!".PHP_EOL, FILE_APPEND);
  echo file_get_contents('ftp://u784337761:vWJG3oCVBK@ftp.rozbyn.esy.es/f.txt');
?>