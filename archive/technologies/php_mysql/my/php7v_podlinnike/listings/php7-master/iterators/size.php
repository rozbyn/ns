<?php ## Использование методов класса DirectoryIterator.
  $dir = new DirectoryIterator(__DIR__);
  echo '<pre>';
  foreach($dir as $file) {
	echo '<div style="border: 2px solid; margin: 10px;">';
    echo 'isDir(): "'.($file->isDir()?'true':'false') . '"<br>';
    echo 'isFile(): "'.($file->isFile()?'true':'false') . '"<br>';
    echo 'getType(): "'.$file->getType() . '"<br>';
    echo 'getFilename(): "'.$file->getFilename() . '"<br>';
    echo 'getPath(): "'.$file->getPath() . '"<br>';
    echo 'getPathname(): "'.$file->getPathname() . '"<br>';
    echo 'getSize(): "'.$file->getSize() . '"<br>';
	echo  '</div>';
  }
?>