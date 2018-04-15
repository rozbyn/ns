<?php 

return [
	'' => [
		'controller' => 'main',
		'action' => 'index'
	],
	
	'contacts' => [
		'controller' => 'main',
		'action' => 'contact'
	],
	
	'index.php' => [
		'controller' => 'main',
		'action' => 'redirectIndex'
	],
	
	'account/login' => [
		'controller' => 'account',
		'action' => 'login'
	],
	
	'account/register' => [
		'controller' => 'account',
		'action' => 'register'
	],
	
	'account' => [
		'controller' => 'account',
		'action' => 'redirectLogin'
	],
	
	'news/show' => [
		'controller' => 'news',
		'action' => 'show'
	],
	
	'news' => [
		'controller' => 'news',
		'action' => 'redirectShow'
	],
];