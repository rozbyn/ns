<?php 

return [
	'' => [
		'controller' => 'main',
		'action' => 'index'
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
	
	'contacts' => [
		'controller' => 'main',
		'action' => 'contact'
	],
	
];