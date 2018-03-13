<?php
class node {
	public $value;
	public $next;
	function __construct($val = 0, $next = null){
		$this->value = $val;
		$this->next = $next;
	}
}
class linked_list {
	private $head=null;
	private $tail=null;
	private $count=0;
	
	public function echoAll(){
		$node =& $this->head;
		if($node === null){
			echo '(Nothing to show)' . '<br>';
		}
		echo '<br>';
		while($node != null){
			echo $node->value . '<br>';
			$node =& $node->next;
		}
		echo '<br>';
	}
	
	public function add($val=null){
		$newNode = new node($val);
		if($this->head === null){
			$this->head =& $newNode;
			$this->tail =& $newNode;
		} else {
			$this->tail->next =& $newNode;
			$this->tail =& $newNode;
		}
		$this->count++;
	}
	
	public function remove($val){
		$previous = null;
		$current =& $this->head;
		while ($current != null){
			if($current->value == $val){
				if($previous != null){
					$previous->next =& $current->next;
					if($current->next === null){
						$this->tail =& $previous;
					}
				} else {
					$this->head =& $this->head->next;
					if($this->head === null){
						$this->tail = null;
					}
				}
				$this->count--;
				return true;
			}
			$previous =& $current;
			$current =& $current->next;
		}
		return false;
	}
	
	public function contains($val){
		$current =& $this->head;
		while($current != null){
			if($current->value == $val){
				return true;
			}
			$current =& $current->next;
		}
		return false;
	}
	
	public function copyTo (&$arr, $startPos = 0){
		$current =& $this->head;
		while($current != null){
			$arr[$startPos++] = $current->value;
			$current =& $current->next;
		}
	}
	
	public function clear(){
		$this->head = null;
		$this->tail = null;
		$this->count = 0;
	}
	
	public function count(){return $this->count;}
	
	
}

$list = new linked_list;
$list->add('1hello');
$list->add('2привет');
$list->add('3приведус');
$list->add('4пока');
$list->add('5покедавас');
$list->add('5покедавас');
$list->add('5покедавас');
$list->add('5покедавас');
$list->add('5покедавас');
$list->add('5покедавас');
$list->add('5покедавас');

$list->echoAll();













?>
<style>
	body{
		font-family: monospace;
		font-size: 12px;
	}
</style>