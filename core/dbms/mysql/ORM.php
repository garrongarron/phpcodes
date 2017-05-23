<?php
namespace DB;

use dbms\mysql\DB;
class ORM
{
	private $tableName = null;
	private $fields = null;
	private $fieldSelected = 'id';
	
	public function __construct(){
		$this->addField('id');
	}
	
	protected function setTableName($tableName){
		$this->tableName = $tableName;
	}
	
	protected function addField($nameField){
		$this->fields[$nameField] =   array(
				'type'=>'int',
				'null'=>true,
				'autoIncremet'=>false );
		$this->fieldSelected = $nameField;
		return $this;
	}
	
	protected function integer(){
		$this->fields[$this->fieldSelected]['type'] = 'int';
		return $this;
	}
	
	protected function string(){
		$this->fields[$this->fieldSelected]['type'] = 'string';
		return $this;
	}
	
	protected function date(){
		$this->fields[$this->fieldSelected]['type'] = 'date';
		return $this;
	}
	
	protected function timestamp(){
		$this->fields[$this->fieldSelected]['type'] = 'timestamp';
		return $this;
	}
	
	protected function notNull(){
		$this->fields[$this->fieldSelected]['null'] = false;
		return $this;
	}

	protected function autoIncrement(){
		$this->fields[$this->fieldSelected]['autoIncremet'] = true;
		return $this;
	}
	
	protected function primaryKey(){
		$this->fields[$this->fieldSelected]['pk'] = true;
		return $this;
	}
	
	public function getFields(){
		return $this->fields;
	}
	
	public function getTableName(){
		return $this->tableName;
	}

	protected function save(){
		$driver = new TableCreator();
		$driver->createTable($this);
	}
	
	public function setUp(){}


	protected function getFieldNames(){
		return get_object_vars($this);
	}
	
	public function insert(){
		$data = $this->getValues();
		$query = "INSERT INTO `".DB."`.`".$this->tableName
		."` (".implode(", ", $data['names']).") VALUES ("
				.implode(",", $data['values']).")";
		DB::q($query);
	}
	
	public function clearData(){
		$fields = $this->getFieldNames();
		foreach ($fields['fields'] as $k =>$v){
			$set = 'set'.ucfirst($k);
			$val = $this->$set(null);
		}
	}
	
	private function getValues(){
		$fields = $this->getFieldNames();
		$names = [];
		$values = [];
		foreach ($fields['fields'] as $k =>$v){
			$get = 'get'.ucfirst($k);
			array_push($names, '`'.$k.'`');
			$val = $this->$get();
			array_push($values, (!empty($val)?"'$val'":' null '));
		}
		return array('names'=>$names,'values'=>$values);
	}

	public function select(){

		$data = $this->getValues();
		$conditions = ['1 = 1'];
		for ($i = 0; $i < count($data['values']); $i++) {
			if($data['values'][$i]!== ' null ')
				$conditions[] = $data['names'][$i] .' = ' . $data['values'][$i];
		}
		$query = "SELECT * FROM `".DB."`.`".$this->tableName
		."` WHERE ".implode(' AND ', $conditions).' ';
		$data = DB::qta($query);
		if(count($data)==1){
			foreach ($data[0] as $k=>$value){
				$set = 'set'.ucfirst($k);
				$this->$set($value);
			}
		}
		return $data;
	}
	
	
	public function update(){
		$data = $this->getValues();
		$fields = $this->fields;
		$flag = false;
		for ($i = 0; $i < count($data['values']); $i++) {
			$name = str_replace('`', '',$data['names'][$i]);
			if(isset($fields[$name]['pk'])&&$fields[$name]['pk']== true){
				if($data['values'][$i] !== null)
				$conditions[] = $data['names'][$i] .' = ' . $data['values'][$i];
				$flag = true;
				continue;
			}
			if($data['values'][$i]!== ' null ')
				$values[] = $data['names'][$i] .' = ' . $data['values'][$i];
		}
		if($flag){
			$query = "UPDATE `".DB."`.`".$this->getTableName()."` SET ".implode(', ', $values)
			." WHERE ".implode(' AND ', $conditions);
			DB::q($query);
		} else {
			echo 'error';
		}
	}
	
	public function delete(){
		$data = $this->getValues();
		$fields = $this->fields;
		$flag = false;
		for ($i = 0; $i < count($data['values']); $i++) {
			$name = str_replace('`', '',$data['names'][$i]);
			if(isset($fields[$name]['pk'])&&$fields[$name]['pk']== true){
				if($data['values'][$i] !== null)
					$conditions[] = $data['names'][$i] .' = ' . $data['values'][$i];
				$flag = true;
				continue;
			}
		}
		if($flag){
			$query = "DELETE FROM 	`".DB."`.`".$this->getTableName()."` "
					." WHERE ".implode(' AND ', $conditions);
			DB::q($query);
		} else {
			echo 'error';
		}
	}
}