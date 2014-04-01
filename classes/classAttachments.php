<?php

class Attachment{

	var $clientid;	
	
	var $blobid;	//unique identifier in the blobs table

	var $display_name;
	var $description;
	var $display_order;
	var $name;
	var $type;
	var $size;
	var $path;

	var $currentTdClass = 'td2';	//this var holds the style that this attachment will be displayed with

	var $statusMessage = '';	//this var will hold a status message that will be displayed. methods in this class can change this var.


	function __construct($_clientid, $_blobid){

		$this->clientid = $_clientid;
		$this->blobid = $_blobid;

		$this->build();
	}

	
	function build(){

		$query = sprintf("SELECT * FROM `blobs` WHERE `blobid` = '%s'",$this->blobid);
		  if($_SESSION['DEBUG']) echo $query . "<BR />";
		$result = mysql_query($query);
		$error = mysql_error();

		$attachmentBlobIdData = mysql_fetch_assoc($result);

		$this->display_name = $attachmentBlobIdData['display_name'];
		$this->description = $attachmentBlobIdData['description'];
		$this->display_order = $attachmentBlobIdData['display_order'];
		$this->name = $attachmentBlobIdData['name'];
		$this->type = $attachmentBlobIdData['type'];
		$this->size = $attachmentBlobIdData['size'];
		$this->path = $attachmentBlobIdData['path'];

	}



	function deleteRow(){

		$args = func_get_args();	//get all the arguments.
		$numargs = func_num_args();	//should never be more than 1

		for($i=0;$i<$numargs;$i++){
			
			if($args[$i] == 'delete'){

				$query = sprintf("DELETE FROM `blobs` WHERE `blobid`='%s'", $args[$i] );
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

		echo "<table class=\"table\" width=\"80%\"><A id=link><TR onMouseOver=\"javascript:this.style.cursor='hand';\" onClick=\"javascript:viewAttachment('" . $this->blobid . "')\">";

		for($i=0;$i<$numargs;$i++){
			
			if($args[$i] == 'icon'){
				
				echo "<td class=\"$this->currentTdClass\" width=\"4%\">";		

				$filenamestring = explode(".", $this->name);
			
				if(($filenamestring[1]=='txt') || ($filenamestring[1]=='wri') || ($filenamestring[1]=='rtf')){
					echo "<IMG src=\"images/text-x-generic.png\" alt=\"".$filenamestring[1]." file\">";
				}
				else if(($filenamestring[1]=='doc') || ($filenamestring[1]=='docx') || ($filenamestring[1]=='odt')){
					echo "<IMG src=\"images/x-office-document.png\" alt=\"".$filenamestring[1]." file\">";
				}
				else{
						echo "<IMG src=\"images/package-x-generic.png\" alt=\"".$filenamestring[1]." file\">";
				}
			
				echo "</td>";
			}else if($args[$i] == 'delete'){
				
				echo "<td class=\"$this->currentTdClass\" width=\"5\">";
				
				/////////// at some point i'll have to log this action?
				echo "<a href=\"adminattachments.php\"></a>";
				echo "</td>";
			
			}else{

				echo "<td class=\"$this->currentTdClass\" width=20%>";
				echo $this->{$args[$i]};
				echo "</td>";
	
			}
		}

		echo "</tr></a></table>";
		
	}



}

?>