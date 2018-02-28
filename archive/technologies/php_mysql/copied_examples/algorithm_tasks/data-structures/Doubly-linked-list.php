<?php
class Dnode {
	public $value;
	public $next;
	public $previous;
	function __construct($val = 0, $next = null, $previous = null){
		$this->value = $val;
		$this->next = $next;
		$this->previous = $previous;
	}
}
class Dlinked_list {
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
			$pr = ($node->previous)?$node->previous->value:'NULL';
			$nx = ($node->next)?$node->next->value:'NULL';
			
			echo $pr . '<-'.$node->value.'->'.$nx . '<br>';
			$node =& $node->next;
		}
		echo '<br>';
	}
	
	public function addFirst($val=null){
		$newNode = new Dnode($val);
		$newNode->next =& $this->head;
		if($newNode->next === null){
			$this->tail =& $newNode;
		} else {
			$this->head->previous =& $newNode;
		}
		$this->head =& $newNode;
		$this->count++;
	}
	
	public function addLast($val=null){
		$newNode = new Dnode($val);
		$newNode->previous =& $this->tail;
		if($newNode->previous === null){
			$this->head =& $newNode;
		} else {
			$this->tail->next =& $newNode;
		}
		$this->tail =& $newNode;
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
					} else {
						$current->next->previous =& $previous;
					}
				} else {
					return removeFirst();
				}
				$this->count--;
				return true;
			}
			$previous =& $current;
			$current =& $current->next;
		}
		return false;
	}
	
	public function removeFirst(){
		if($this->head != null){
			$this->head =& $this->head->next;
			$this->count--;
			if($this->count == 0){
				$this->tail = null;
			} else {
				$this->head->previous = null;
			}
			return true;
		} else {
			return false;
		}
		
	}
	
	public function removeLast(){//*TODO!!
		if($this->tail != null){
			$this->tail =& $this->tail->previous;
			$this->count--;
			if($this->count == 0){
				$this->head = null;
			} else {
				$this->tail->next = null;
			}
			return true;
		} else {
			return false;
		}
		
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

$list = new Dlinked_list;
$list->addFirst('1hello');
$list->addFirst('2привет');
$list->addFirst('3приведус');
$list->addFirst('4пока');
$list->addFirst('5покедавас');
$list->addFirst('6hello');
$list->addLast('7покедавас');


$list->echoAll();













?>
<style>
	body{
		font-family: monospace;
		font-size: 12px;
	}
</style>