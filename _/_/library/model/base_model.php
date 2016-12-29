<?php
class base_model{
	public $db;
	public function __construct($model){
		import('source.class.mysql');
		$db = new mysql();
		$this->db = $db->table($model);
	}
}
?>