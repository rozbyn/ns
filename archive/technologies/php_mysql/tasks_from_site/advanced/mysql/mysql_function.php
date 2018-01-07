<?php
function is_empty(&$something){
	if (isset($something)){
		if ($something === '0'){
			return false;
		} elseif ($something === 0){
			return false;
		} else {
			return empty($something);
		}
	} else {
		return true;
	}
}
function arrt($arr){
	foreach($arr as $key => $val){
		if (is_array($val)){
			arrt($val);
		} else {
			echo $key . ':' . $val . '<br>';
		}
	}
}
function connect_DB ($database = 'test', $user = 'root', $password = '', $address = 'localhost'){
	$db_mysqli = new mysqli($address, $user, $password, $database);
	if (mysqli_connect_errno()){
		printf("Не удалось подключиться: %s\n", mysqli_connect_error());
		$db_mysqli = false;
	} else {
		$db_mysqli -> set_charset("utf8");
	}
	return $db_mysqli;
}
/*
$i = connect_DB();
$stmt_query = 'SELECT * FROM guest_book';
$stmt = $i->prepare($stmt_query);
$stmt->execute();
$stmt->bind_result($kl1,$kl2,$kl3,$kl4,$kl5,$kl6);
while ($stmt->fetch()) {
	echo $kl1.$kl2.$kl3.$kl4.$kl5.$kl6.'</br>';
}
SHOW COLUMNS FROM sometable
$j = $i->query('SHOW COLUMNS FROM guest_book');
for ($res = []; $row = $j->fetch_assoc(); $res[] = $row);
$columnNames = [];
foreach($res as $key=>$val){
	$columnNames[] = $val['Field'];
}


echo '<pre>';
var_dump($columnNames);
echo '</pre>';
*/
function query_mysqli($db_mysqli, $stmt_query='SELECT * FROM guest_book', $arrOfBindParams = [], $arrResultParams=[]){
	if ($db_mysqli instanceof mysqli){
		$str = substr($stmt_query, 0, strpos($stmt_query, ' '));
		if ($str == 'SELECT'){
			if (empty($arrOfBindParams)){
				if ($stmt = $db_mysqli->prepare($stmt_query)){
					if(method_exists($stmt, 'get_result')){
						if($stmt->execute()){
							$res = $stmt->get_result();
							for ($result = []; $row = $res->fetch_assoc(); $result[] = $row);
							$stmt->close();
						} else {
							echo 'Не удалось выполнить запрос!' . '<br>' . $db_mysqli->error;
							return false;
						}
					} else {
					}
				} else {
					echo 'Не удалось сформировать запрос!' . '<br>' . $db_mysqli->error;
					return false;
				}
			} else {
				if ($stmt = $db_mysqli->prepare($stmt_query)){
					$refArr2=[];
					foreach($arrOfBindParams as $key => $val){
						$refArr2[] = &$arrOfBindParams[$key];
					}
					$ref = new ReflectionClass('mysqli_stmt');
					$method = $ref->getMethod("bind_param");
					$method->invokeArgs($stmt, $refArr2);
					if($stmt->execute()){
						if(method_exists($stmt, 'get_result')){
							$res = $stmt->get_result();
							for ($result = []; $row = $res->fetch_assoc(); $result[] = $row);
							$stmt->close();
						} else {
							/*----*/
						}
					} else {
						echo 'Не удалось выполнить запрос!' . '<br>' . $db_mysqli->error;
						return false;
					}
				} else {
					echo 'Не удалось сформировать запрос!' . '<br>' . $db_mysqli->error;
					return false;
				}
			}
		} else {
			if (empty($arrOfBindParams)){
				if ($stmt = $db_mysqli->prepare($stmt_query)){
					if($stmt->execute()){
						$result = true;
						$stmt->close();
					} else {
						echo 'Не удалось выполнить запрос!' . '<br>' . $db_mysqli->error;
						return false;
					}
				} else {
					echo 'Не удалось сформировать запрос!' . '<br>' . $db_mysqli->error;
					return false;
				}
			} else {
				if ($stmt = $db_mysqli->prepare($stmt_query)){
					$refArr2=[];
					foreach($arrOfBindParams as $key => $val){
						$refArr2[] = &$arrOfBindParams[$key];
					}
					$ref = new ReflectionClass('mysqli_stmt');
					$method = $ref->getMethod("bind_param");
					$method->invokeArgs($stmt, $refArr2);
					if($stmt->execute()){
						$result = true;
						$stmt->close();
					} else {
						echo 'Не удалось выполнить запрос!' . '<br>' . $db_mysqli->error;
						return false;
					}
				} else {
					echo 'Не удалось сформировать запрос!' . '<br>' . $db_mysqli->error;
					return false;
				}
			}
		}
	} else {
		return false;
	}
	return $result;
}
/*--------------------------------------------------*/
/*
header('Content-Type: text/html; charset=utf-8');

$myDbObj = connect_DB();
$query = "SELECT * FROM guest_book WHERE record_id = ?";
$arrOfParams = ['i', 4];
$k = query_mysqli($myDbObj, $query, $arrOfParams);
echo '<pre>';
var_dump($k);
echo '</pre>';
*/
/*
$db = new mysqli("localhost","root","","test");
$res = $db->prepare("INSERT INTO test SET foo=?,bar=?");
$refArr = array("si","hello", 42);
$refArr2=[];
foreach($refArr as $key => $val){
	$refArr2[] = &$refArr[$key];
}
//var_dump($refArr2);
$ref = new ReflectionClass('mysqli_stmt');
$method = $ref->getMethod("bind_param");
$method->invokeArgs($res,$refArr2);
$res->execute();  

*/

?>