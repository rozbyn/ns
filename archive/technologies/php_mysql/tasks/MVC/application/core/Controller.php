<?php 

namespace application\core;

use application\core\View;

abstract class Controller 
{
	public $route;
	public $view;
	public $acl;
	
	
	public function __construct($route)
	{
		$this->route = $route;
		if (!$this->checkAcl()) {
			View::errorCode(403);
		}
		$this->view = new View($route);
		$this->model = $this->loadModel($route['controller']);
	}
	
	public function loadModel ($name)
	{
		$path = 'application\models\\'. ucfirst($name) .'';
		if (class_exists($path)) {
			return new $path;
		}
		return false;
	}
	
	public function checkAcl ()
	{
		$filePath = 'application/acl/' . $this->route['controller'] . '.php';
		if (file_exists($filePath)) {
			
			$this->acl = require $filePath;
			if ($this->isAcl('all')) {
				
				return true;
			} elseif (
				isset($_SESSION['authorize']['id']) && 
				$this->isAcl('authorize')
			) {
				return true;
			} elseif (
				!isset($_SESSION['authorize']['id']) && 
				!isset($_SESSION['admin']) && 
				$this->isAcl('guest')
			) {
				return true;
			} elseif (
				isset($_SESSION['admin']) && 
				$this->isAcl('admin')
			) {
				return true;
			}
		} else {
			echo 'Нет файла с доступами' . '<br>';
		}
		return false;
	}
	
	public function isAcl ($key) 
	{
		return in_array($this->route['action'], $this->acl[$key]);
	}
}