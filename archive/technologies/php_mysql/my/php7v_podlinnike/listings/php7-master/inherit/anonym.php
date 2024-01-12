<?php ## Использование анонимных классов
  class Dumper
  {
    public static function print2($obj)
    {
      print_r($obj);
    }
  }

  Dumper::print2( new class {
    public $title;
    public function __construct(){
      $this->title = "Hello world!";
    }
  });
?>