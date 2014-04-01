<?php

class Attachments{

	var $clientid;	
	
	var $blobid;	//unique identifier in the blobs table

	var $display_name;
	var $description;
	var $display_order;
	var $name;
	var $type;
	var $size;
	var $path;
		
	function __construct($_clientid, $blobid){

		$this->clientid = $_clientid;
		$this->blobid = $blobid;

		$this->build();
	}

	
	function build(){


		$query = sprintf("SELECT * FROM `blobs` WHERE `blobid` = '%s'",$this->blobid);
		echo $query;
		$result = mysql_query($query);

		$error = mysql_error;


	}


?>