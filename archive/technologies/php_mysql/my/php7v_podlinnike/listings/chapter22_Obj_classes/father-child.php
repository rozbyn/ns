<?php
class Father
{
	public $name = '';
	public $childrens = [];
	function __construct ($name)
	{
		$this->name = $name;
	}
	function __destruct ()
	{
		echo "Father {$this->name} умер!<br>";
	}
}

class Child
{
	public $name = '';
	public $father;
	function __construct ($name='', Father $father)
	{
		$this->name = $name;
		$this->father = $father;
	}
	function __destruct ()
	{
		echo "Child {$this->name} умер!" . '<br>';
	}
}

$father = new Father('Авраам');
$child = new Child('Исаак', $father);

$father->childrens[] = $child;

echo "Убиваем всех" . '<br>';
$father = $child = null;
echo "Все умерли! Конец программы!" . '<br>';