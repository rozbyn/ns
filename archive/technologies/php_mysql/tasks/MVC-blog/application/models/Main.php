<?php 

namespace application\models;

use application\core\Model;

class Main extends Model
{
	public $lastError = false;
	
	public function contactValidate ($post) 
	{
		$nameLen = mb_strlen($post['name']);
		$textLen = mb_strlen($post['text']);
		if ($nameLen < 2 || $nameLen > 20) {
			$this->lastError = 'Имя должно быть больше 2 символов и меньше 20!';
			return false;
		}
		if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->lastError = 'Введите корректный E-mail!';
			return false;
		}
		if ($textLen < 10 || $textLen > 500) {
			$this->lastError = 'Текст сообщения должен быть больше 10 символов и меньше 500!';
			return false;
		}
		return true;
	}
	
	public function postsCount () {
		$r = $this->db->column('SELECT COUNT(id) FROM posts');
		return $r;
	}
	
	public function postsList ($start, $limit) {
		$params = [
			'start' => $start,
			'limit' => $limit,
		];
		$r = $this->db->row('SELECT * FROM posts ORDER BY id DESC LIMIT :start , :limit ', $params);
		return $r;
	}
	
	
	public function showPost ($id) {
		return $this->db->row('SELECT * FROM posts WHERE id = :id', ['id'=>$id]);
	}
	
}