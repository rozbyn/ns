<?php 

namespace application\controllers;

use application\core\Controller;

class AccountController extends Controller
{
	public function loginAction()
	{
		if (!empty($_POST['send'])) {
			//$this->view->location($GLOBALS['bDir']);
			$this->view->message($_POST['log'], $_POST['pas']);
		}
		$this->view->render('Страница входа');
	}
	
	public function registerAction()
	{
		$this->view->render('Страница регистрации');
	}
	
	public function redirectLoginAction()
	{
		$this->view->redirect($GLOBALS['bDir'] . '/account/login');
	}
}