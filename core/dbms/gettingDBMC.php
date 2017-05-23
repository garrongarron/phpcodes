<?php
if(DBMS == 'mysql'){
	require_once 'core/dbms/mysql/DB.php';
	require_once 'core/dbms/mysql/ORM.php';
	require_once 'core/dbms/mysql/TableCreator.php';
}