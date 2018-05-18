<?php
class asdasd 
{
	public $h0 = 19230;
	public $h1 = 19230;
	public $h2 = 19230;
	public $h3 = 19230;
	public $h4 = 19230;
	public $h5 = 19230;
	public $h6 = 19230;
	public $h7 = 19230;
	public $h8 = 19230;
	public $h9 = 19230;
	public $h10 = 19230;
	public $h11 = 19230;
	public $h12 = 19230;
	public $h13 = 19230;
	public function h13 ($a) 
	{
		return $a**$a;
	}
	
	
}
  // Распечатывает дамп переменной на экран.
  function dumper($obj)
  {
    echo 
      "<pre>",
        htmlspecialchars(dumperGet($obj)),
      "</pre>"; 
  }
  // Возвращает строку - дамп значения переменной в древовидной форме 
  // (если это массив или объект). В переменной $leftSp хранится 
  // строка с пробелами, которая будет выводиться слева от текста.
  function dumperGet(&$obj, $leftSp = "")
  { 
    if (is_array($obj)) {
      $type = "Array[".count($obj)."]"; 
    } elseif (is_object($obj)) {
      $type = "Object";
    } elseif (gettype($obj) == "boolean") {
      return $obj? "true" : "false";
    } else {
      return "\"$obj\"";
    }
    $buf = $type; 
    $leftSp .= "    ";
    foreach($obj as $k=>$v) {
      if ($k === "GLOBALS") continue;
      $buf .= "\n$leftSp$k => ".dumperGet($v, $leftSp);
    }
    return $buf;
  }

  
$r = 'asdasdasd';
$t = false;
$o = new asdasd;


//dumper($GLOBALS);
dumper($r);
dumper($t);
dumper($o);
var_dump($r);