<?php


class Cmain {
	
	public function eeqe($param) {
		$this->__getClassForPath($param);
	}


	final private function __getClassForPath($componentPath){
		echo 'original __getClassForPath: '.$componentPath;
	}
	
	
	function __construct() {
		
	}

}


$class = new Cmain;

$refl = new ReflectionClass($class);
$meth = $refl->getMethod('__getClassForPath');
$meth->setAccessible(true);
$class->__getClassForPath('3-40289402');


//$class->eeqe('/aasdas/sadas/d/asd/as/d.dl');

