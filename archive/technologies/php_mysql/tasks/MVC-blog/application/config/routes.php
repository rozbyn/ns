<?php 

return [

	// Main Controller
	
	'' => [
		'controller' => 'main',
		'action' => 'index'
	],
	
	"main/index/(?'page'\d+)?\/?" => [
		'controller' => 'main',
		'action' => 'index'
	],
	
	'contact' => [
		'controller' => 'main',
		'action' => 'contact'
	],
	
	'about' => [
		'controller' => 'main',
		'action' => 'about'
	],
	
	"post\/?(?'id'\d+)?\/?" => [
		'controller' => 'main',
		'action' => 'post'
	],
	
	'index.php' => [
		'controller' => 'main',
		'action' => 'index'
	],
	
	// Admin Controller
	
	'admin' => [
		'controller' => 'admin',
		'action' => 'login'
	],
	
	'admin/login' => [
		'controller' => 'admin',
		'action' => 'login'
	],
	
	'admin/logout' => [
		'controller' => 'admin',
		'action' => 'logout'
	],
	
	'admin/add' => [
		'controller' => 'admin',
		'action' => 'add'
	],
	
	"admin/edit\/?(?'id'\d+)?\/?" => [
		'controller' => 'admin',
		'action' => 'edit'
	],
	
	"admin/delete\/?(?'id'\d+)?\/?" => [
		'controller' => 'admin',
		'action' => 'delete'
	],
	
	"admin/posts\/?(?'page'\d+)?\/?" => [
		'controller' => 'admin',
		'action' => 'posts'
	],
	
];