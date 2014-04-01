<?php


include('classField.php');
include('classAttachments.php');



class Client{

	var $clientid;	
	var $fields = array();
	var $attachments = array();

	function __construct($_clientid){

		$this->clientid = $_clientid;

		$this->build();
		$this->refresh();

	}




	function build(){

		//it would be good to make this more memory efficient later.

		$query = sprintf("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='profile'");
		$query = mysql_query($query);
		$profileColumnData = $query;
	
		while($row = mysqlfetch_array($profileColumnData)){
			

			${$row[0]} = new field($row[0]);
			$this->fields[$row[0]] = ${$row[0]};

		}
		
	}


	//refresh every part
	function refresh(){

		$query = sprintf("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='profile'");
		$result = mysql_query($query);
		$profileColumnData = $result;		//this holds the internal field name

		$query = sprintf("SELECT * FROM `profile` WHERE `clientid`= '%s'", $this->clientid);
		$result = mysql_query($query);
		$result = mysql_fetch_array($result);	//this holds the value of the field
	
		if($_SESSION['DEBUG']==1){ echo count($result) . "<BR /><BR />"; }

		for($i=0;$i <= ((count($result)/2)-1);$i++){ 		//this was an ugly fix for field miscount

			$row = mysql_fetch_array($profileColumnData);
			if($_SESSION['DEBUG']==1){ echo $i . " : " . $row[0] . " - "; }

			if( isset($result[$i]) ){
		
				$this->fields[$row[0]]->value = $result[$i];
				if($_SESSION['DEBUG']==1){ echo $result[$i] . "<BR />"; }

			}
			else{

				$this->fields[$row[0]]->value = '';
				if($_SESSION['DEBUG']==1){ echo $result[$i] . "<BR />"; }
			}
			
		 }

		//run the other refresh functions once we are done the main code body
		refreshAttachments(); 

	}


	//refresh just the attachments
	function refreshAttachments(){

		$attachments = '';
		$attachments = array();

		$query = sprintf("SELECT * FROM `blobs` WHERE `clientid` = '%s'", $this->clientid);
		$result = mysql_query($query);
		$attachmentColumnData = $result;

		for($i=0;$i < mysql_num_rows($result);$i++){


			
		}

	}


}


?>