<?php 

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Main;

class AdminController extends Controller
{
	public function __construct($route)
	{
		parent::__construct($route);
		$this->view->layout = 'admin';
	}
	
	public function loginAction()
	{
		if (
			isset($_SESSION['admin']) &&
			$_SESSION['admin'] = true
		) {
			$this->view->redirect($GLOBALS['bDir'].'/admin/add');
		}
		if (!empty($_POST)) {
			if ($this->model->loginValidate($_POST)) {
				$_SESSION['admin'] = true;
				$this->view->location($GLOBALS['bDir'] . '/admin/add');
			} else {
				$this->view->message('Ошибка', $this->model->lastError);
			}
		}
		$this->view->render('Страница входа');
	}
	
	public function logoutAction()
	{
		unset($_SESSION['admin']);
		$this->view->redirect('../');
	}
	
	public function addAction()
	{
		if (!empty($_POST)) {
			if ($this->model->postValidate($_POST, 'add')) {
				if ($id = $this->model->postAdd($_POST)) {
					$this->view->message('Успех', 'id: '.$id, true);
					$this->model->uploadImage($_FILES['img']['tmp_name'], $id);
				}
			}
			$this->view->message('Ошибка', $this->model->lastError);
		}
		$this->view->render('Добавить пост');
	}
	
	public function postsAction()
	{
		$mainModel  = new Main;
		$this->route['page'] = $this->route['page'] ?? 1;
		$pagination = new Pagination($this->route, $mainModel->postsCount(), 9);
		$ga = $pagination->get();
		$vars = [
			'pagination' => $ga['html'],
			'list' => $mainModel->postsList($ga['start'], $ga['limit']),
		];
		$this->view->render('Все посты', $vars);
	}
	
	public function editAction()
	{
		if (!isset($this->route['id'])) {
			$this->view->redirect('posts');
		}
		if (!empty($_POST)) {
			if ($this->model->postValidate($_POST, 'edit')) {
				$a = $this->model->postEdit($_POST, $this->route['id'], 'edit');
				if ($a) {
					$this->view->message('Успех', "Запись с ID: ".$this->route['id']." успешно отредактирована", true);
					if (!empty($_FILES['img']['tmp_name'])) {
						$this->model->uploadImage($_FILES['img']['tmp_name'], $this->route['id']);
					}
				} else {
					$this->view->message('Ошибка', $this->model->lastError);
				}
			} else {
				$this->view->message('Ошибка', $this->model->lastError);
			}
		} else {
			$a = $this->model->postEdit($_POST, $this->route['id'], 'show');
			if ($a === false) {
				header('Refresh: 5; url=../posts');
				exit($this->model->lastError);
			} else {
				$this->view->render('Редактировать запись №'.$this->route['id'], ['data' => $a]);
			}
		}
	}
	
	public function deleteAction()
	{
		if (!isset($this->route['id'])) {
			$this->view->redirect('posts');
		} else {
			if ($this->model->postDelete($this->route['id'])) {
				$this->view->redirect('../posts');
			} else {
				header('Refresh: 5; url=../posts');
				exit($this->model->lastError);
			}
		}
		$this->view->render('Удаление записи');
	}
	
}