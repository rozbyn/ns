<?php

namespace application\lib;

use PDO;

class Db
{
	protected $db;
	
	public function __construct() 
	{
		$config = require 'application/config/db.php';
		$this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].'', $config['user'], $config['password']);
		
	}
	
	public function query($sql, $params = [], $returnCount = false) 
	{
		$stmt = $this->db->prepare($sql);
		if (!empty($params)) {
			foreach ($params as $key => $val) {
				
				if (is_int($val)) {
					$type = PDO::PARAM_INT;
				} else {
					$type = PDO::PARAM_STR;
				}
				$stmt->bindValue(':'.$key, $val, $type);
			}
		}
		
		if ($stmt->execute() === false) {
			return implode('; ', $stmt->errorInfo()).' ;'. $stmt->queryString;
		}
		
		if ($returnCount) {
			return $stmt->rowCount();
		}
		
		return $stmt;
	}
	
	public function row($sql, $params = []) 
	{
		$result = $this->query($sql, $params);
		if (is_string($result)) {
			return $result;
		}
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function column($sql, $params = []) 
	{
		$result = $this->query($sql, $params);
		return $result->fetchColumn();
	}
	
	public function lastInsertId () {
		return $this->db->lastInsertId();
	}
	
	
}