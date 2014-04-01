<?php


include('classField.php');
include('classAttachments.php');
include('classNotes.php');
include('classAccounts.php');



class Client{

	var $clientid;	
	var $fields = array();
	var $attachments = array();	//$attachments is an array of attachment objects. the references are `blobids`.
	var $notes = array();
	var $accounts = array();	

	function __construct($_clientid){

		$this->clientid = $_clientid;

		$this->build();
		$this->refresh();

	}


////////////////////////////////////////////////////////////////////////////////////////////////////////


	function build(){

		//it would be good to make this more memory efficient later.

		$query = sprintf("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='profile'");
		$query = mysql_query($query);
		$profileColumnData = $query;
	
		while($row = mysql_fetch_array($profileColumnData)){
			

			${$row[0]} = new field($row[0]);
			$this->fields[$row[0]] = ${$row[0]};

		}
		
	}


////////////////////////////////////////////////////////////////////////////////////////////////////////


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
		$this->refreshAttachments(); 
		$this->refreshNotes();
		$this->refreshAccounts();

	}


////////////////////////////////////////////////////////////////////////////////////////////////////////


	function displayInputBox($_fieldname, $_type){		
		
		$fieldvalue = $this->fields[$_fieldname];
		$fielddisplayname = $this->fields[$_fieldname]->PrintDisplayname();		

		$html_output=      "<td class=\"td2\">
				". $fielddisplayname ." <BR /><BR />
				<input type=\"text\" value=\"".$fieldvalue."\" name=\"$_fieldname\" size=\"30\">
				</td>";
	
	return $html_output;	
	}


////////////////////////////////////////////////////////////////////////////////////////////////////////


	function refreshAttachments(){

		$attachments = '';
		$attachments = array();

		$query = sprintf("SELECT `blobid` FROM `blobs` WHERE `clientid` = '%s'", $this->clientid);
		$result = mysql_query($query);

		for($i=0;$i < mysql_num_rows($result);$i++){

			$attachmentBlobIdData = mysql_fetch_array($result);
			$this->attachments[$i] = new Attachment($this->clientid,$attachmentBlobIdData[0]);
		}

	}

	function refreshNotes(){

		$notes = '';
		$notes = array();

		$query = sprintf("SELECT `messageid` FROM `messages` WHERE `clientid` = '%s'", $this->clientid);
		$result = mysql_query($query);

		for($i=0;$i < mysql_num_rows($result);$i++){

			$NoteIdData = mysql_fetch_array($result);
			$this->notes[$i] = new Note($this->clientid,$NoteIdData[0],$i);
		}

	}

	function refreshAccounts(){

		$accounts = '';
		$accounts = array();

		$query = sprintf("SELECT `accountid` FROM `accounts` WHERE `clientid` = '%s'", $this->clientid);
		$result = mysql_query($query);

		for($i=0;$i < mysql_num_rows($result);$i++){

			$AccountIdData = mysql_fetch_array($result);
			$this->accounts[$i] = new Account($this->clientid,$AccountIdData[0],$i);
		}

	}


////////////////////////////////////////////////////////////////////////////////////////////////////////

}


?>