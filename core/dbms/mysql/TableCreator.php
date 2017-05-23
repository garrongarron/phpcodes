<?php
namespace DB;

use dbms\mysql\DB;
class TableCreator
{

	public function createTable(ORM $table){
		if(!$this->tableExist($table->getTableName())){
			$db  = DB::getInstance(true);
			$db->query($this->parser($table));
// 			DB::q($this->parser($table));
			$table->setUp();
			$table->clearData();
		}
	}
	private function parser(ORM $table){
		$query = "CREATE TABLE `".DB."`.`".$table->getTableName()."` (";
		$fields = [];
		$primaryKeys = [];
		$autoIncrement = '';
		foreach ($table->getFields() as $key => $value) {
			switch ($value['type']) {
				case 'int':
					$type = ' int';
					break;
				case 'string':
					$character = 45;
					if(isset($value['type-caracter'])){
						$character = $value['type-caracter'];
					}
					$type = " VARCHAR($character)";
					break;
						
				case 'date':
					$type = ' DATETIME';
					break;
				case 'timestamp':
					$type = ' TIMESTAMP';
					break;
				default:
						
					break;
			};
			
			$null  = ($value['null'])?' NULL':' NOT NULL';
			
			$autoIncrement  = ($value['autoIncremet'])?' AUTO_INCREMENT':'';

			if(isset($value['pk']))
				array_push($primaryKeys,$key);
			
			$string = "`".$key."` ".$type." ".$null.$autoIncrement;
			array_push($fields,$string  );
		}
		
		$pk = (!empty($primaryKeys))?
		', PRIMARY KEY (`'.implode('`, `', $primaryKeys).'`) ':'';

		$query .= implode(', ', $fields). $pk .")";
		
		return $query;
	}

	public function tableExist($table){
		$result = DB::qta("SHOW TABLES LIKE '".$table."'");
		if (!empty($result)) {
			return true;
		} else {
			return false;
		}
	}
}

