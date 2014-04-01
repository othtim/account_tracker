<?php

class field{

	var $CoreName;
	var $DisplayName;
	var $error;

	var $value;

	function __construct($_coreName){

		$this->printDisplayName($_coreName);
		$this->CoreName = $_coreName;

	}

	
	function __toString(){

		return $this->value;
	}


	function printDisplayName($_coreName){
		
		$_query = sprintf("SELECT displayFieldName FROM `fields` WHERE `coreFieldName` = '%s'", $_coreName);
		$_query = mysql_fetch_array(mysql_query($_query));		

		$this->DisplayName = $_query[0];

		$this->error = mysql_error();
		

	}

	function setDisplayName($_newDisplayName){

		$_query = sprintf("UPDATE `fields` SET `displayFieldname` = '%s' WHERE `coreFieldName` = '%s'", mysql_real_escape_string($_newDisplayName), mysql_real_escape_string($this->CoreName) );
		$_query = mysql_query($_query);
	
		$this->error = mysql_error();
	}

	
}




















?>