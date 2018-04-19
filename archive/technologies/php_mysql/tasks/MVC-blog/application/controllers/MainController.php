<?php 

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Admin;

class MainController extends Controller
{
	public function indexAction()
	{
		$this->route['page'] = $this->route['page'] ?? 1;
		$pagination = new Pagination($this->route, $this->model->postsCount(), 9);
		$ga = $pagination->get();
		$vars = [
			'pagination' => $ga['html'],
			'list' => $this->model->postsList($ga['start'], $ga['limit']),
		];
		$this->view->render('Главная страница', $vars);
	}
	
	public function contactAction()
	{
		if (!empty($_POST)) {
			if ($this->model->contactValidate($_POST)) {
				$this->view->message('Успех', 'Сообщение отправлено', true);
				$messageText = "Имя: ".$_POST['name'].'<br>';
				$messageText .= "E-mail: ".$_POST['email'].'<br>';
				$messageText .= "Сообщение: ".$_POST['text'].'<br>';
				sendSmtp('ADMIN', 'ezcs@ro.ru', 'Сообщение из блога', $messageText);
				exit;
			} else {
				$this->view->message('Ошибка', $this->model->lastError);
			}
		}
		
		$this->view->render('Контакты');
	}
	
	public function aboutAction()
	{
		$this->view->render('Обо мне');
	}
	
	public function postAction()
	{
		$r = $this->model->showPost($this->route['id']);
		if (empty($r)) {
			$this->view->errorCode(404);
		}
		$vars['data'] = $r[0];
		$this->view->render($r[0]['name']. ' - MVC блог', $vars);
	}
	
}