<pre>
<?php
function massArrToString($arr, $vgf = 0, $resStr = ''){
	if ($vgf == 0){
			$resStr = '|r|2|3|4|5|6|7|8|9|' . '<br>';
		}
		foreach($arr as $key => $value){
			$resStr .= str_repeat('| ',$vgf);
			if (is_array($value)){
				$vgf++;
				$resStr .= '|' . $key . '<br>';
				$resStr = massArrToString($arr[$key], $vgf, $resStr);
				--$vgf;
			} else {
				$resStr .= '|' . $value . '<br>';
			}
			
		}
	return $resStr;
}
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
	public $head=null;
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
	
	public function removeLast(){
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
class Stack extends Dlinked_list{
	public function push(&$val){
		$this->addFirst($val);
	}
	public function &pop(){
		$res = ($this->head)?$this->head->value:false;
		$this->removeFirst();
		return $res;
	}
	public function peek(){
		return ($this->head)?$this->head->value:false;
	}
}
class binaryTreeNode{
	public $value = NULL;
	public $left = NULL;
	public $right = NULL;
	function __construct($val = NULL){
		$this->value = $val;
	}
}

class binaryTree{
	protected $rootObj = NULL;
	private $count = 0;
	public function treeToString2 ($node = 'root', $lvl = 0, $pr = 'root', $parent = NULL, &$tArr = 0){
		$node = ($node!=='root') ? $node : $this->rootObj;
		if($tArr === 0){
			$tArr = [];
		}
		$tArr[$lvl][] = ['value'=>$node->value, 'direction'=>$pr, 'parent'=>$parent];
		$pra = count($tArr[$lvl])-1;
		($node->left)? $this->treeToString2 ($node->left, $lvl+1, 'L', $pra, $tArr):'';
		($node->right)? $this->treeToString2 ($node->right, $lvl+1, 'R', $pra, $tArr):'';
		if($node === $this->rootObj){
			for($i=0;$i<count($tArr);$i++){
				if($i === 0){
					$tArr2[0][] = ['val'=>$tArr[0][0]['value'], 'len'=>strlen($tArr[0][0]['value']), 'Lb'=>0, 'Rb'=>0, 'P'=>0, 'D'=>'root', 'parent'=>NULL, 'Lchild'=>NULL, 'Rchild'=>NULL];
					continue;
				}
				$strlen = 0;
				for($j=0;$j<count($tArr[$i]);$j++){
					$val = $tArr[$i][$j]['value'];
					$len = strlen($val);
					$direction = $tArr[$i][$j]['direction'];
					$curParent = $tArr[$i][$j]['parent'];
					if($direction === 'L'){
						$parentPivot =& $tArr2[$i-1][$curParent]['P'];
						$moveOn = $strlen  - ($parentPivot - ($len+2));
						if($moveOn>0){
							if(!function_exists('moveTreeToRight')){
								function moveTreeToRight(&$arr, $level, $elem, $move, $from = 'L', $b = false){
									$element =& $arr[$level][$elem];
									if($from === 'R'){
										$b ? false : $element['Rb'] += $move;
										if($element['parent'] !== NULL){
											moveTreeToRight($arr, $level-1, $element['parent'], $move, $element['D'], true);
											return;
										}
									} else {
										$b ? $element['Lb'] += $move : false;
										$element['P'] += $move;
									}
									if($element['Lchild'] !== NULL  && $from === 'P'){
										moveTreeToRight($arr, $level+1, $element['Lchild'], $move, 'P');
									}
									if($element['Rchild'] !== NULL && $from !== 'R'){
										moveTreeToRight($arr, $level+1, $element['Rchild'], $move, 'P');
									}
									if($element['parent'] !== NULL && $from !== 'P'){
										moveTreeToRight($arr, $level-1, $element['parent'], $move, $element['D']);
									}
								}
							}
							moveTreeToRight($tArr2, $i-1, $curParent, $moveOn);
						}
						$currentPivot = $parentPivot - ($len+1);
						$tArr2[$i-1][$curParent]['Lb'] = 1;
						$tArr2[$i-1][$curParent]['Lchild'] = $j;
						$strlen = $strlen + $len + 1;
						$tArr2[$i][] = ['val'=>$val, 'len'=>$len, 'Lb'=>0, 'Rb'=>0, 'P'=>$currentPivot, 'D'=>$direction, 'parent'=>$curParent, 'Lchild'=>NULL, 'Rchild'=>NULL];
						
					} else {
						$parentPivot =& $tArr2[$i-1][$curParent]['P'];
						$parentLen = $tArr2[$i-1][$curParent]['len'];
						$tArr2[$i-1][$curParent]['Rb'] = 1;
						$tArr2[$i-1][$curParent]['Rchild'] = $j;
						$currentPivot = $parentPivot+$parentLen+1;
						$strlen = $currentPivot + $len + 1;
						$tArr2[$i][] = ['val'=>$val, 'len'=>$len, 'Lb'=>0, 'Rb'=>0, 'P'=>$currentPivot, 'D'=>$direction, 'parent'=>$curParent, 'Lchild'=>NULL, 'Rchild'=>NULL];
					}
				}
			}
			$tArr = [];
			foreach($tArr2 as $lvl=>$lvlArr){
				$strlen = 0;
				$tArr[$lvl*2] = '';
				$tArr[$lvl*2+1] = '';
				foreach($lvlArr as $elem){
					$add = $elem['P'] + $elem['Rb'] + $elem['len'];
					$tArr[$lvl*2] = str_pad($tArr[$lvl*2], $add);
					$tArr[$lvl*2+1] = str_pad($tArr[$lvl*2+1], $add);
					$tStr2 =& $tArr[$lvl*2];
					$tStr3 =& $tArr[$lvl*2+1];
					$elem['val'] .= '';
					for($i = 0; $i<$elem['len']; $i++){
						$tStr2[$elem['P']+$i] = $elem['val'][$i];
					}
					if($elem['Rb'] !== 0){
						if($elem['Rb']>1){
							$d = $elem['Rb']-1;
							for($j = 0; $j < $d; $j++){
								$tStr2[$elem['P']+$elem['len']+$j] = '_';
							}
							$tStr3[$elem['P']+$elem['len']+$j] = '\\';
						} else {
							$tStr3[$elem['P']+$elem['len']] = '\\';
						}
					}
					if($elem['Lb'] !== 0){
						if($elem['Lb']>1){
							$tStr3[$elem['P']-$elem['Lb']] = '/';
							for($j = $elem['Lb']-1; $j > 0; $j--){
								$tStr2[$elem['P']-$j] = '_';
							}
						} else {
							$tStr3[$elem['P']-1] = '/';
						}
					}
				}
			}
			array_pop($tArr);
			return implode(PHP_EOL, $tArr);
		}
	}

	public function count(){
		return $this->count;
	}
	public function treeToArray($node = 'root', $pr = 'root-'){
		$retArr = [];
		$node = ($node!=='root')?$node:$this->rootObj;
		if($node){
			$left = $this->treeToArray($node->left, 'L-');
			$right = $this->treeToArray($node->right, 'R-');
			$mer = $right + $left;
			$retArr[$pr . $node->value] = $mer;
		}
		return $retArr;
	}
	public function toArr(){
		return (array) $this;
	}
	public function add($val){
		if($this->rootObj === NULL){
			$this->rootObj = new binaryTreeNode($val);
		} else {
			$this->addTo($this->rootObj, $val);
		}
		$this->count++;
	}
	private function addTo(binaryTreeNode &$node, $val){
		if($val < $node->value){
			if($node->left === NULL){
				$node->left = new binaryTreeNode($val);
			} else {
				$this->addTo($node->left, $val);
			}
		} else {
			if($node->right === NULL){
				$node->right = new binaryTreeNode($val);
			} else {
				$this->addTo($node->right, $val);
			}
		}
	}
	private function findWithParent($val){
		$retArr = [];
		$parent = NULL;
		$currentNode =& $this->rootObj;
		while($currentNode != NULL){
			if($val < $currentNode->value){
				$parent =& $currentNode;
				$currentNode =& $currentNode->left;
			} elseif($val > $currentNode->value){
				$parent =& $currentNode;
				$currentNode =& $currentNode->right;
			} else {
				$retArr[0] =& $currentNode;
				$retArr[1] =& $parent;
				return $retArr;
			}
		}
		return false;
	}
	public function remove($val){
		if($f = $this->findWithParent($val)){
			$parent =& $f[1];
			$removeNode =& $f[0];
			if($removeNode->left === NULL && $removeNode->right === NULL){
				$removeNode = NULL;
			} elseif ($removeNode->right === NULL){
				$removeNode = $removeNode->left;
			} elseif ($removeNode->left === NULL){
				$removeNode = $removeNode->right;
			} else {
				if($removeNode->right->left === NULL){
					$removeNode->right->left =& $removeNode->left;
					$removeNode = $removeNode->right;
				} else {
					$lowestValOnRightSubTree =& $removeNode->right->left;
					while($lowestValOnRightSubTree->left != NULL){
						$lowestValOnRightSubTree =& $lowestValOnRightSubTree->left;
					}
					$removeNode->value = $lowestValOnRightSubTree->value;
					if($lowestValOnRightSubTree->right != NULL){
						$lowestValOnRightSubTree = $lowestValOnRightSubTree->right;
					} else {
						$lowestValOnRightSubTree = NULL;
					}
				}
			}
			$this->count--;
			
		} else {
			return false;
		}
	}
	public function contains($val){
		return $this->findWithParent($val)[0] != null;
	}
	public function clear(){
		$this->count = 0;
		$this->rootObj = NULL;
	}
	public function PreOrderTraversal(callable $action){
		$this->PreOrder2Traversal($action, $this->rootObj);
	}
	private function PreOrder2Traversal(callable $action, &$node){
		if($node != NULL){
			$action($node->value);
			$this->PreOrder2Traversal($action, $node->left);
			$this->PreOrder2Traversal($action, $node->right);
		}
	}
	public function InOrderTraversal(){
		$retArr = [];
		$current = $this->rootObj;
		$stack = new Stack;
		$stack->push($current);
		$goLeftNext = true;
		while($stack->count() > 0){
			if($goLeftNext){
				while($current->left != NULL){
					$stack->push($current);
					$current = $current->left;
				}
			}
			$retArr[] = $current->value;
			if($current->right != NULL){
				$current =& $current->right;
				$goLeftNext = true;
			} else {
				$current = $stack->pop();
				$goLeftNext = false;
			}
		}
		return $retArr;
		
	}
}


$T = new binaryTree;
$T->add(50);
$T->add(60);
$T->add(70);
$T->add(80);
$T->add(90);
$T->add(100);
$T->add(40);
$T->add(20);
$T->add(10);
$T->add(5);
$T->add(30);
$T->add(45);
$T->add(35);
$T->add(37);
$T->add(25);
$T->add(23);
$T->add(24);
$T->add(21);
$T->add(22);
$T->add(20);
$T->add(23);
$T->add(24);
$T->add(27);
$T->add(26);
$T->add(28);
$T->add(29);
$T->add(34);
$T->add(33);
$T->add(31);
$T->add(32);
$T->add(38);
$T->add(39);
$T->add(99);
$T->add(98);
$T->add(97);
$T->add(96);
$T->add(95);
$T->add(94);
$T->add(101);
$T->add(102);
$T->add(103);
$T->add(104);
$T->add(105);
$T->add(106);

//$T->remove(100);
//$T->clear();


/* $f = function(&$val){
	$val *= 10;
};
$T->PreOrderTraversal($f); */


echo $T->treeToString2() . '<br>';
echo massArrToString($T->treeToArray());

echo $T->count() . '<br>';



//var_dump($T);

/* 
    $host = 'ya.ru';
	$asd = mb_convert_encoding(`ping -n 3 {$host}`, 'UTF8', 'CP866');
	echo $asd . '<br>';
 */

//$asd = [10=>[15=>[220=>[], 321=>[]], 20=>[]]];
//print_r($asd);






























?>
<style>
	body{
		font-family: monospace;
		font-size: 12px;
	}
</style>
</pre>
