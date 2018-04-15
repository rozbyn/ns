<?php 

namespace application\controllers;

use application\core\Controller;

class MainController extends Controller
{
	public function indexAction()
	{
		$result = $this->model->getNews();
		$vars = [
			'name' => 'Вася',
			'age' => 88,
			'news' => $result
		];
		$this->view->render('Главная страница', $vars);
	}
	public function contactAction()
	{
		$this->view->render('Контакты');
	}
	
}