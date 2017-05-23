<?php
namespace Model;

use DB\DB;
use DB\ORM;

class User extends ORM
{
	private $id;
	private $name;
	private $pass;

	static private $instance = null;

	static public function getInstance(){
		if(self::$instance===null){
			self::$instance = new User();
		}
		return self::$instance;
	}

	public function __construct(){
		$this->setTableName('users');
		$this->addField('id')->integer()->notNull()->autoIncrement()->primaryKey();
		$this->addField('name')->string()->notNull();
		$this->addField('pass')->string()->notNull();
		$this->save();
	}

	public function setUp(){
		$this->setName('John')->setPass('secretpassword')->insert();
		$this->setName('Peter')->setPass('secretpassword')->insert();
	}

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
		return $this;
	}

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
		return $this;
	}

	public function getPass(){
		return $this->pass;
	}

	public function setPass($pass){
		$this->pass = $pass;
		return $this;
	}

}