<?php
	date_default_timezone_set('Europe/Moscow');
// Скопированный и измененный пример использования класса
	class User
	{
		protected $name;
		protected $age;
		private $id;
		private $db;
		//при создании объекта класса присваивается случайный id
		public function __construct(){
			$this -> id = mt_rand(99,999);
		}
		public function getName(){return $this->name;}
		public function setName($nm){$this->name = $nm;}
		public function getAge(){return $this->age;}
		public function setAge($ag){$this->age = $ag;}
		public function getId(){return $this->id;}

	}
	class Worker extends User{
		private $salary;
		public function getSalary(){return $this->salary;}
		public function setSalary($salary){$this->salary = $salary;}
	}
	class Student extends User{
		private $course;
		public function getCourse(){return $this->course;}
		public function setCourse($crs){$this->course = $crs;}
		public function addOneYear(){$this->age++;}
		public function setAge($age){
			if ($age<=25){
				parent::setAge($age);
			}
		}
		
	}

	$itp = new Worker;
	$itp->setSalary(1000);
	$itp->setName('Kolya');
	$itp->setAge(654);
	$itp2= new Student;
	$itp2-> setName('Vasya');
	$itp2-> setAge(13);
	$itp2-> setCourse(5);
	$itp3= new Student;
	$itp3-> setName('Petya');
	$itp3-> setAge(21);
	$itp3-> setCourse(4);
	$itp3-> addOneYear();
	$itp3-> addOneYear();
	$itp3-> addOneYear();
	$itp3-> addOneYear();
	$itp3-> addOneYear();
	$itp3-> addOneYear();
	$itp3-> setAge(999);//не сработает
	$kkd = new User;
	$kkd -> setName('Gosha');
	$kkd -> setAge('55');
	
	
	/*-------------Отобразить все объекты и потомки класса User */
	$divv='';
	foreach (get_defined_vars() as $kkey=>$bas){
		if(is_object($bas) && (is_subclass_of($bas, 'User') || get_class($bas) == 'User')){
			$divv .= '<div>';
			$divv .= 'КЛАСС: ' . get_class($bas) . '<br>';
			$divv .= 'ИМЯ: ' . $bas->getName() . '<br>';
			$divv .= 'ВОЗРАСТ: ' . $bas->getAge() . '<br>';
			if (method_exists($bas,'getSalary')){$divv .= 'ЗАРПЛАТА: ' . $bas->getSalary() . '<br>';}
			if (method_exists($bas,'getCourse')){$divv .= 'КУРС: ' . $bas->getCourse() . '<br>';}
			$divv .= 'ID: ' . $bas->getId() . '<br>';
			$divv .= '</div>';
		}
	}


?>
<!doctype html>
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
			<?php echo $divv ?>
	</body>
</html>
	
