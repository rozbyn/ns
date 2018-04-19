<?php 

namespace application\models;

use application\core\Model;

class Admin extends Model
{
	public $lastError = false;
	
	public function loginValidate ($post) 
	{
		$config = require 'application/config/admin.php';
		if (
			$_POST['login'] === $config['login'] && 
			$_POST['password'] === $config['password']
		) {
			return true;
		}
		$this->lastError = 'Логин или пароль указан неверно';
		return false;
	}
	
	public function postValidate ($post, $type) {
		$nameLen = mb_strlen($post['name']);
		$descLen = mb_strlen($post['description']);
		$textLen = mb_strlen($post['text']);
		if ($nameLen < 3 || $nameLen > 100) {
			$this->lastError = 'Название должно быть больше 3 символов и меньше 100!';
			return false;
		}
		if ($descLen < 3 || $descLen > 100) {
			$this->lastError = 'Описание должно быть больше 3 символов и меньше 100!';
			return false;
		}
		if ($textLen < 10 || $textLen > 5000) {
			$this->lastError = 'Текст должен быть больше 10 символов и меньше 5000!';
			return false;
		}
		if ($type == 'add' && empty($_FILES['img']['tmp_name'])) {
			$this->lastError = 'Загрузите изображение';
			return false;
		}
		return true;
	}
	
	public function postAdd ($post) {
		$params = [
			'id' => '',
			'description' => $post['description'],
			'name' => $post['name'],
			'text' => $post['text'],
			'date' => time(),
		];
		$p = $this->db->query('INSERT INTO posts VALUES (:id, :name, :description, :text, :date)', $params);
		if (!is_object($p)) {
			$this->lastError = $p;
			return false;
		} else {
			return $this->db->lastInsertId();
		}
	}
	
	public function uploadImage ($path, $id) {
		$img = new \Imagick($path);
		$img->cropThumbnailImage(1080, 540);
		$img->setImageCompressionQuality(60);
		$savePath = $GLOBALS['indexPath'] . '/public/materials/'.$id.'.jpg';
		$img->writeImage($savePath);
		/* move_uploaded_file($path, 'public/materials/'.$id.'.jpg'); */
		
	}
	
	public function postDelete ($id) {
		$params = [
			'id' => $id,
		];
		$r = $this->db->query('DELETE FROM posts WHERE id = :id', $params, true);
		if ($r === 0) {
			$this->lastError = 'Записи с ID: ' .$id. ' не существует';
			return false;
		} elseif (is_string($r)) {
			$this->lastError = $r;
			return false;
		}
		$pathToImg = $GLOBALS['indexPath'] . '/public/materials/'.$id.'.jpg';
		if (file_exists($pathToImg)) {
			unlink($pathToImg);
		}
		return true;
	}
	
	public function postEdit ($post, $id, $action = 'show') {
		if ($action === 'show') {
			$r = $this->db->row('SELECT * FROM posts WHERE id = :id', ['id'=>$id]);
			if (is_string($r)) {
				$this->lastError = $r;
				return false;
			} elseif (empty($r)) {
				$this->lastError = 'Записи с ID: ' .$id. ' не существует';
				return false;
			} else {
				return $r[0];
			}
		} elseif ($action === 'edit') {
			$params = [
				'id' => $id,
				'name' => $post['name'],
				'description' => $post['description'],
				'text' => $post['text'],
			];
			$r = $this->db->query('UPDATE posts SET name = :name, description = :description, text = :text WHERE id = :id ', $params, true);
			if ($r === 1) {
				return true;
			} elseif (is_string($r)) {
				$this->lastError = $r;
				return false;
			} elseif ($r === 0) {
				$this->lastError = 'Записи с ID: ' .$id. ' не существует, либо никаких изменений не было';
				return false;
			}
		}
	}
	
	
	
}