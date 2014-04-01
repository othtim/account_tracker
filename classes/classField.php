<?php

class field{

	var $CoreName;
	var $DisplayName;

	var $security;
	var $usersecurity;

	var $value;

	var $error;


	function __construct($_coreName){

		$this->printDisplayName($_coreName);
		$this->CoreName = $_coreName;

	}

	
	function __toString(){

		return $this->value;
	}



	function printDisplayName(){
		
		$_coreName = $this->CoreName;

		$_query = sprintf("SELECT displayFieldName FROM `fields` WHERE `coreFieldName` = '%s'", $_coreName);
		$_query = mysql_fetch_array(mysql_query($_query));		

		$this->DisplayName = $_query[0];

		$this->error = mysql_error();

	return	$_query[0];
	}



	function setDisplayName($_newDisplayName){

		$_query = sprintf("UPDATE `fields` SET `displayFieldname` = '%s' WHERE `coreFieldName` = '%s'", mysql_real_escape_string($_newDisplayName), mysql_real_escape_string($this->CoreName) );
		$_query = mysql_query($_query);
	
		$this->error = mysql_error();
	}




}




















?>