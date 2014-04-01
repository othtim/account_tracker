<?php

class Note{

	var $clientid;	
	
	var $messageid;	//unique identifier in the message table
	var $messageArrayID; //this is what the index for me is in the parent class' array

	var $message;
	var $date;
	var $creator;
	var $security;

	var $currentTdClass = 'td2';	//this var holds the style that this note will be displayed with

		
	function __construct($_clientid, $_messageid, $_messageArrayID){

		$this->clientid = $_clientid;
		$this->messageid = $_messageid;
		$this->messageArrayID = $_messageArrayID;

		$this->build();
	}

	
	function build(){

		$query = sprintf("SELECT * FROM `messages` WHERE `messageid` = '%s'",$this->messageid);
		  if($_SESSION['DEBUG']) echo $query . "<BR />";
		$result = mysql_query($query);
		$error = mysql_error();

		$NotesData= mysql_fetch_assoc($result);

		$this->message = $NotesData['message'];
		$this->date = $NotesData['date'];
		$this->creator = $NotesData['creator'];
		$this->security = $NotesData['security'];

	}



	function deleteRow(){

		$args = func_get_args();	//get all the arguments. if this is  
		$numargs = func_num_args();	//should never be more than 1

		for($i=0;$i<$numargs;$i++){
			
			if($args[$i] == 'delete'){

				$query = sprintf("DELETE FROM `messages` WHERE `messageid`='$s'", $args[$i] );
				$result = mysql_query($query);
				$error = mysql_error();

			} else if($args[$i] == 'somethingelseforlater'){

				//do stuff, maybe log?
			}

		}
		
	return; //something;
	}



	// this function displays all the information nicely in a table format
	//
	function displayRow(){

		$args = func_get_args();	//get all the arguments 
		$numargs = func_num_args();

		echo "<table class=\"table\" width=\"80%\"><A id=link><TR onMouseOver=\"javascript:this.style.cursor='hand';\" onClick=\"javascript:updateNote('" . $this->messageArrayID. "')\">";

		for($i=0;$i<$numargs;$i++){
			
			if($args[$i] == 'icon'){
				
				//do nothing. but maybe add icons later?
				//echo "<td class=\"$this->currentTdClass\" width=\"4%\">";		

				//$filenamestring = explode(".", $this->name);
				//
				//if(($filenamestring[1]=='txt') || ($filenamestring[1]=='wri') || ($filenamestring[1]=='rtf')){
				//	echo "<IMG src=\"images/text-x-generic.png\" alt=\"".$filenamestring[1]." file\">";
				//}
				//else if(($filenamestring[1]=='doc') || ($filenamestring[1]=='docx') || ($filenamestring[1]=='odt')){
				//	echo "<IMG src=\"images/x-office-document.png\" alt=\"".$filenamestring[1]." file\">";
				//}
				//else{
				//		echo "<IMG src=\"images/package-x-generic.png\" alt=\"".$filenamestring[1]." file\">";
				//}
			
				//echo "</td>";
			}else if($args[$i] == 'delete'){
				
				echo "<td class=\"$this->currentTdClass\" width=\"5\">";
				
				/////////// at some point i'll have to log this action?
				echo "<a href=\"adminnotes.php\">delete</a>";
				echo "</td>";

			}else if($args[$i] == 'edithistory'){
				
				echo "<td class=\"$this->currentTdClass\" width=\"5\">";
				
				/////////// at some point i'll have to log this action?
				echo "<a href=\"adminnotes.php\">edithistory</a>";
				echo "</td>";

			}else if($args[$i] == 'creator'){			

				echo "<td class=\"$this->currentTdClass\" width=\"10%\">";
				echo $this->creator;
				echo "</td>";

			}else{

				echo "<td class=\"$this->currentTdClass\">";
				echo $this->{$args[$i]};
				echo "</td>";
	
			}
		}

		echo "</tr></a></table>";
		
	}



	function UpdateRow(){


		$args = func_get_args();	//get all the arguments. 
		$numargs = func_num_args();	//
		$tempDataArray = '';
		$tempDataArray = array();
		$data = '';
		$data = array();

	
		for($i=0;$i<$numargs;$i++){
			
			$tempDataArray = explode('=', $args[$i]);
			$data[$tempDataArray[0]] = $tempDataArray[1];
		}

		//need to convert messageArrayID into a messageid
		$data['messageid']=$this->messageid;
		

		//need to pull the existing note out of the database 
		$query = sprintf("SELECT * FROM notes WHERE `messageid` = '%s'",$data['messageid']);
		//echo $query;

		$result = mysql_query($query);
		$noteData = $result;	
	

		$query = sprintf("UPDATE `messages` SET 
						`message`	= '%s',
						`date`		= '%s',
						`creator`	= '%s',
						`security`	= '%s'
					WHERE `messageid` = '%s'",
						(isset($data['message']) ? $data['message'] : $noteData['message']),
						(isset($data['date']) ? $data['date'] : $noteData['date']),
						(isset($data['creator']) ? $data['creator'] : $noteData['creator'] ),
						(isset($data['security']) ? $data['security'] : $noteData['security']),
						(isset($data['messageid']) ? $data['messageid'] : $noteData['messageid'])
					);
		//echo $query;
		$result = mysql_query($query);
		echo mysql_error();						
	
		//the user was successfully created.
		//echo "The note was successfully updated. <BR />";
		//echo "<meta http-equiv=\"refresh\" content=\"2\">";
		//die();




	}


}

?>