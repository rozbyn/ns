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

class avlTreeNode {
	
	public $value = NULL;
	public $right = NULL;
	public $left = NULL;
	public $height = 0;
	function __construct($val){
		$this->value = $val;
	}
}


class avlBinaryTree{
	private $NULLGUARD = NULL;
	public $count = 0;
	public $root = NULL;
	private $treeToStringArray = [];
	public function treeToArray($node = 'root', $pr = 'root-'){
		$retArr = [];
		$node = ($node!=='root') ? $node : $this->root;
		if($node){
			$left = $this->treeToArray($node->left, 'L-');
			$right = $this->treeToArray($node->right, 'R-');
			$mer = $right + $left;
			$retArr[$pr . $node->value] = $mer;
		}
		return $retArr;
	}
	
	
	public function treeToString2 ($node = 'root', $lvl = 0, $pr = 'root', $parent = NULL, &$tArr = 0){
		$node = ($node!=='root') ? $node : $this->root;
		if($tArr === 0){
			$tArr = [];
		}
		$tArr[$lvl][] = ['value'=>$node->value, 'direction'=>$pr, 'parent'=>$parent];
		$pra = count($tArr[$lvl])-1;
		($node->left)? $this->treeToString2 ($node->left, $lvl+1, 'L', $pra, $tArr):'';
		($node->right)? $this->treeToString2 ($node->right, $lvl+1, 'R', $pra, $tArr):'';
		if($node === $this->root){
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

	private function height(&$node){
		return ($node)?$node->height:0;
	}
	private function bFactor(&$node){
		return $this->height($node->left) - $this->height($node->right);
	}
	private function fixHeight(&$node){
		if(($node->left === NULL) && ($node->right === NULL)){
			$node->height = 0;
			return;
		}
		$hL = $this->height($node->left);
		$hR = $this->height($node->right);
		$node->height = ($hL > $hR ? $hL : $hR) + 1;
	}
	private function &rotateLeft(&$q){
		$p = $q->right;
		$q->right = $p->left;
		$p->left = $q;
		$this->fixHeight($q);
		$this->fixHeight($p);
		return $p;
	}
	private function &rotateRight(&$p){
		$q = $p->left;
		$p->left = $q->right;
		$q->right = $p;
		$this->fixHeight($p);
		$this->fixHeight($q);
		return $q;
	}
	private function &balance(&$node){
		$this->fixHeight($node);
		if($this->bFactor($node) == -2){
			if($this->bFactor($node->right) > 0){
				
				$node->right = $this->rotateRight($node->right);
			}
			return $this->rotateLeft($node);
		}
		if($this->bFactor($node) == 2){
			if($this->bFactor($node->left) < 0){
				$node->left = $this->rotateLeft($node->left);
			}
			return $this->rotateRight($node);
		}
		return $node;
	}
	public function add($val){
		if(!$this->root){
			$this->root = new avlTreeNode($val);
		} else {
			$this->insert($val, $this->root);
		}
		$this->count++;
	}
	private function &insert($val, &$node){
		if(!$node) {
			//echo 'NewVal-'.$val . '<br>';
			$temp=new avlTreeNode($val);
			return $temp;
		}
		if($val < $node->value){
			$node->left = $this->insert($val, $node->left);
		} else {
			$node->right = $this->insert($val, $node->right);
		}
		$node = $this->balance($node);
		return $node;
	}
	private function &findMin(&$p){
		$k = ($p->left) ? $this->findMin($p->left) : $p;
		return $k;
	}
	private function &removeMin(&$p){
		if($p->left == NULL) return $p->right;
		$p->left = $this->removeMin($p->left);
		return $this->balance($p);
	}
	public function remove($val){
		$t = $this->count;
		$this->delete($val, $this->root);
		return ($t>$this->count)?true:false;
	}
	private function &delete($val, &$node){
		if($node == NULL)return $node;
		if($val < $node->value){
			$node->left = $this->delete($val, $node->left);
		} elseif($val > $node->value){
			$node->right = $this->delete($val, $node->right);
		} else {
			$this->count--;
			$nodeL = $node->left;
			$nodeR = $node->right;
			if($nodeL == NULL) return $nodeR;
			if($nodeR == NULL) return $nodeL;
			$min = $this->findMin($nodeR);
			$min->right = $this->removeMin($nodeR);
			$min->left = $nodeL;
			$node = $min;
			return $this->balance($node);
		}
		return $this->balance($node);
	}
	
	
	
	
}


$T = new avlBinaryTree;

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



//var_dump($T->remove(97));
//$T->clear();


/* $f = function(&$val){
	$val *= 10;
};
$T->PreOrderTraversal($f); */

echo ($T->treeToString2()) . '<br>';
//var_dump ($T->treeToString2()) . '<br>';


echo massArrToString($T->treeToArray());
echo $T->count . '<br>';
echo 'Высота: '.$T->root->height . '<br>';
/* 

echo $T->count() . '<br>';
$ty = 5;
$ty = ++$ty + ++$ty;
echo $ty . '<br>';

print_r($T->InOrderTraversal());
 */

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
