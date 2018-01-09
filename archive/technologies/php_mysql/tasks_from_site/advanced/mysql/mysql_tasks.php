<style>
	* {margin:0;padding:0}
	div {
		float: left;
		margin: 5px;
		padding: 5px;
		border: 1px solid black;
	}
	.php_table{
		border-collapse: collapse;
	}
	.php_table td{
		padding: 5px;
		border: 1px solid black;
	}
</style>
<?php

function arrt($arr){
	foreach($arr as $key => $val){
		if (is_array($val)){
			arrt($val);
		} else {
			echo $key . ':' . $val . '<br>';
		}
	}
}

function make_table($headTable = ['#', 'name', 'count', 'something'], $arrOfData = [[1, 'lolol', 33, 'what?'], [2, 'komomo', 99, 'nowhere']]){
	echo '<table class = "php_table"><thead>';
	foreach ($headTable as $val){
		echo '<td>' . $val . '</td>';
	}
	echo '</thead>';
	echo '<tbody>';
	foreach ($arrOfData as $record){
		echo '<tr>';
		foreach($record as $val){
			echo '<td>' . $val . '</td>';
		}
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';
}
/*--------------------------------------------------*/

header('Content-Type: text/html; charset=utf-8');

echo '<div>';////////////
$dbTestConnection = new mysqli('localhost', 'u784337761_root', 'nSCtm9jplqVA', 'u784337761_test');
$dbTestConnection -> set_charset("utf8");
if (mysqli_connect_errno()){
	printf("Не удалось подключиться: %s\n", mysqli_connect_error());
	exit();
} else {
	echo 'Соединение с базой успешно установлено' . '<br>';
}
$showTable = true;
if(!empty($_GET['del_w_button'])){
	if (!empty($_GET['del_w_records'])){
		if ($stmt = $dbTestConnection -> prepare("DELETE FROM workers WHERE id REGEXP ?")){
			$one = implode('|', $_GET['del_w_records']);
			
			$stmt->bind_param("s", $one);
			$stmt->execute();
			$stmt->close();
		} else {
			echo 'Не удалось сформировать запрос!' . '<br>';
			echo $dbTestConnection->error;
		}
	}

} elseif (!empty($_GET['edit_id'])){
	$showTable = false;
	if ($stmt = $dbTestConnection -> prepare("SELECT id, name, age, salary FROM workers WHERE id=?")){
		$stmt->bind_param("i", $_GET['edit_id']);
		$stmt->execute();
		$stmt->bind_result($id, $name, $age, $salary);
		$stmt->fetch();
		$stmt->close();
		$tableHead = ['id', 'name', 'age', 'salary'];
		$idInput = '<input type="hidden" name="id" value="'.$id.'"><b>'.$id.'</b>';
		$nameInput = '<input type="text" name="name" value="'.$name.'">';
		$ageInput = '<input type="text" name="age" value="'.$age.'">';
		$salaryInput = '<input type="text" name="salary" value="'.$salary.'">';
		$doneButton = '<input type="submit" name="sendEditWorker" value="Готово">';
		$res = [[$idInput, $nameInput, $ageInput, $salaryInput, $doneButton]];
		echo '<form action="" method = "GET">';
		make_table($tableHead, $res);
		echo '</form>';
	} else {
		echo 'Какая то ошибка' . '<br>';
	}
} elseif (!empty($_GET['sendEditWorker'])){
	if (isset($_GET['name']) && isset($_GET['age']) && isset($_GET['salary'])&& isset($_GET['id'])){
		if ($stmt = $dbTestConnection -> prepare("UPDATE workers SET name=?, age=?, salary=? WHERE id = ?")){
			$stmt->bind_param("siii", $_GET['name'], $_GET['age'], $_GET['salary'], $_GET['id']);
			if($stmt->execute()){
				echo 'Запрос на изменение успешно выполнен.' . '<br>';
			} else {
				echo 'Запрос на изменение НЕ ВЫПОЛНЕН!!!' . '<br>';
				echo $stmt->error . '<br>';
			}
			$stmt->close();
		} else {
			echo 'Не удалось сформировать запрос.' . '<br>';
		}
	}
} elseif (!empty($_GET['new_worker'])){
	$showTable = false;
	$tableHead = ['name', 'age', 'salary'];
	$nameInput = '<input type="text" name="name" value="">';
	$ageInput = '<input type="text" name="age" value="">';
	$salaryInput = '<input type="text" name="salary" value="">';
	$doneButton = '<input type="submit" name="sendNewWorker" value="Готово">';
	$res = [[$nameInput, $ageInput, $salaryInput, $doneButton]];
	echo '<form action="" method = "GET">';
	make_table($tableHead, $res);
	echo '</form>';
} elseif (!empty($_GET['sendNewWorker'])){
	if (isset($_GET['name']) && isset($_GET['age']) && isset($_GET['salary'])){
		if ($stmt = $dbTestConnection -> prepare("INSERT INTO workers SET name=?, age=?, salary=?")){
			$stmt->bind_param("sii", $_GET['name'], $_GET['age'], $_GET['salary']);
			if($stmt->execute()){
				echo 'Запрос на создание успешно выполнен.' . '<br>';
			} else {
				echo 'Запрос на создание НЕ ВЫПОЛНЕН!!!' . '<br>';
				echo $stmt->error . '<br>';
			}
			$stmt->close();
		} else {
			echo 'Не удалось сформировать запрос.' . '<br>';
		}
	}
}

$some_query = false;
if ($some_query){
	$query = 'INSERT INTO workers (name, age, salary) VALUES
						("Дима", 23, 400),
						("Петя", 25, 500), 
						("Вася", 23, 500), 
						("Коля", 30, 1000), 
						("Иван", 27, 500), 
						("Кирилл", 28, 1000)';
	if ($stmt = $dbTestConnection -> prepare($query)){
			if($stmt->execute()){
				echo 'Все хорошо =)' . '<br>';
			} else {
				echo 'Прости =(' . '<br>';
				echo $stmt->error;
			}
			$stmt->close();
		} else {
			echo 'Не удалось...=\'(' . '<br>';
			echo $dbTestConnection->error . '<br>';
		}
}




if ($showTable){
	echo '<form action="" method="GET">';
	echo 'Выбрать работников с зарплатой' . '<br>';
	$lastSalaryFilter = '';
	if(isset($_GET['salary_filter'])){
		$lastSalaryFilter = $_GET['salary_filter'];
	}
	echo '<input type="text" name="salary_filter" value='.$lastSalaryFilter.'><input type="submit" name="sal_filt_submit" value="Выбрать">';
	echo '</form>';
	if (isset($_GET['sal_filt_submit'])){
		if(isset($_GET['salary_filter']) && $_GET['salary_filter'] !== ''){
			if ($stmt = $dbTestConnection -> prepare("SELECT * FROM workers WHERE salary=?")){
				$stmt->bind_param("i", $_GET['salary_filter']);
				if($stmt->execute()){
					$result = $stmt->get_result();
				}
				$stmt->close();
				$showAllTable = false;
			}
		} else {
			$showAllTable = true;
		}
	} else {
		$showAllTable = true;
	}
	
	if($showAllTable){
		if ($stmt = $dbTestConnection -> prepare('SELECT * FROM workers')){
			if($stmt->execute()){
				$result = $stmt->get_result();
				$vse_ok = true;
			} else {
				echo 'Запрос НЕ ВЫПОЛНЕН!!!' . '<br>';
				echo $stmt->error;
			}
			$stmt->close();
		} else {
			echo 'Не удалось сформировать запрос.' . '<br>';
			echo $dbTestConnection->error . '<br>';
		}
	}
	if (isset($result)){
		if (is_object($result)){
			for ($res = []; $row = $result->fetch_assoc(); $res[] = $row);
			$headTable = [];
			if (!empty($res)){
				foreach($res[0] as $key => $val){
					$headTable[] = '<b>'.$key.'</b>';
				}
				$headTable[] = '<b>Удалить?</b>';
				$headTable[] = '<b>Изменить</b>';
				foreach($res as $key => $arr1){
					$res[$key][] = '<input type="checkbox" name="del_w_records[]" value="'.$arr1['id'].'">';
					$res[$key][] = '<a href="mysql_tasks.php?edit_id='.$arr1['id'].'">Изменить</a>';
				}
				$res[][]= '<a href="mysql_tasks.php?new_worker=1">Новый</a>';
				$res[count($res)-1][]= '';
				$res[count($res)-1][]= '';
				$res[count($res)-1][]= '';
				$res[count($res)-1][]= '<input type="submit" name="del_w_button" value="Удалить">';
				echo '<form action="" method="GET">';
				make_table($headTable, $res);
				echo '</form>';
			} else {
				echo '<a href="mysql_tasks.php?new_worker=1">Новый</a>';
			}
		} elseif ($result === false){
			if ($vse_ok){
				echo 'Запрос успешно выполнен' . '<br>';
			} else {
				echo 'Такого быть не может!!!' . '<br>';
				echo $dbTestConnection->error;
			}
		}
	} else {
		echo 'Не удалось получить результат.' . '<br>';
	}

}
$dbTestConnection->close();

echo '</div>';///////////
echo '<div>';////////////



?>
<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/practice/praktika-php-dlya-novichkov.html" target="_blank">Страница учебника</a></div>