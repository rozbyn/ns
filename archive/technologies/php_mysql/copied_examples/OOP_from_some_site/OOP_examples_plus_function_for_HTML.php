

<?php
// Пример функции с параметрами (скопировано)
function makecoffee($types = array("капуччино"), $coffeeMaker = NULL)
{
    $device = is_null($coffeeMaker) ? "вручную" : $coffeeMaker;
    return "Готовлю чашку ".join(", ", $types)." $device.\n";
}
echo makecoffee();
echo makecoffee(["капуччино", "лавацца"], "в чайнике");
// // // //

// Пример создания и использования класса для HTML форм(скопировано)
class Form{
	//функция берет каждый элемент массива и возвращает набор HTML свойств для тегов
	public function arrTohtml($arra=[]){
		$htmlText = '';
		foreach($arra as $tag => $val){
			$htmlText .= "$tag = \"$val\" ";
		}
		return $htmlText;
	}
	//функции создания тегов 
	public function open($arr=[]){
		return '<form ' . $this -> arrTohtml($arr) . '>';
	}
	public function close($arr=[]){
		return '</form ' . $this -> arrTohtml($arr) . '>';
	}
	public function input($arr=[]){
		return '<input ' . $this -> arrTohtml($arr) . '>';
	}
	public function password($arr=[]){
		return '<input type="password"' . $this -> arrTohtml($arr) . '>';
	}
	public function submit($arr=[]){
		return '<input type="submit"' . $this -> arrTohtml($arr) . '>';
	}
	public function textarea($arr=[]){
		$valuee = '';
		if (isset($arr['value'])){$valuee = $arr['value']; unset($arr['value']);}
		return '<textarea ' . $this -> arrTohtml($arr) . '>' . $valuee . '</textarea>';
	}
}
$jfj = new Form;
$content2 = '';
$content2 .=  $jfj->open(['action'=>'index.php', 'method'=>'POST']);
$content2 .=   $jfj->input(['type'=>'text', 'value'=>'!!!']). '<br>';
$content2 .=   $jfj->password(['value'=>'!!!']). '<br>';
$content2 .=   $jfj->submit(['value'=>'GO!']). '<br>';
$content2 .=   $jfj->textarea(['placeholder'=>'123', 'value'=>'Йоуе йуеа', 'class'=>'miya']). '<br>';
$content2 .=   $jfj->close();
$content2 .=   $jfj->arrTohtml() . '<br>';
// // // //


//функция создания любого HTML тега с любым кол-вом тегов и любым контентом (самостоятельно писал, но неудобно в использовании)
function t($arr=['type'=>'div', 'class'=>'test'], $content='text'){
	$tag = array_shift($arr);
	$html = '<' .$tag. ' ';
	foreach($arr as $key=>$val){
		$html .= $key . '="' . $val . '"';
	}
	$html .= '>'.$content.'</'.$tag.'>';
	return $html;
}



//arrHtml
$content2.=	
t(['label'], 'hello'
	.t(['ul', 'class'=>'tevued', 'id'=>'one']
		,t(['li', 'id'=>'twoOne'], 'один')
		.t(['li', 'id'=>'twoTwo'], 'два')
		.t(['li', 'id'=>'twoThree'], 'три')
		.t(['li', 'id'=>'twoFour'], 'четыре')
	)
);
// // // //
?>








<!DOCTYPE html>
<html>
	<head>
		<style>
			body {
				background:#CCCCFF;
				color : #0030FF;
			}
			div {
				float:left;
				margin:5px;
			}
		</style>
	</head>
	<body>
			<?=$content2  ?>
	</body>
</html>
	
