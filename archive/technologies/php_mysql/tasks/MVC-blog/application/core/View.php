<?php 



namespace application\core;

class View 
{
	public $path;
	public $route;
	public $layout = 'default';
	
	
	
	public function __construct($route) 
	{
		$this->route = $route;
		$this->path = $route['controller'] . '/' . $route['action'];
	}
	
	public function render($title, $vars = [])
	{
		
		$path = 'application/views/' . $this->path . '.php';
		if (file_exists($path)) {
			extract($vars);
			ob_start();
			require $path;
			$content = ob_get_clean();
			require 'application/views/layouts/' . $this->layout . '.php';
		} else {
			echo 'Вид не найден: "' . $path . '"<br>';
		}
	}
	
	public static function errorCode($code) 
	{
		http_response_code($code);
		require 'application/views/errors/' . $code . '.php';
		exit;
	}
	
	public static function redirect($url, $code = 307) 
	{
		http_response_code($code);
		header('location: ' . $url);
		exit;
	}
	
	public static function message ($status, $message, $noExit = false) 
	{
		if ($noExit) {
			$str = json_encode(['status' => $status, 'message' => $message]);
			endConnection($str);
		} else {
			exit(json_encode(['status' => $status, 'message' => $message]));
		}
	}
	
	public static function location ($url) 
	{
		exit(json_encode(['url' => $url]));
	}
	
}