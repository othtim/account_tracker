<?php

class Account{

	var $clientid;	
	
	var $accountid;	//unique identifier in the blobs table
	var $accountArrayID; //this is what the index for me is in the parent class' array

	var $accountType;
	var $investmentObjectives;
	var $percentIncome;
	var $percentBalanced;
	var $percentGrowth;


	var $currentTdClass = 'td2';	//this var holds the style that this attachment will be displayed with

		
	function __construct($_clientid, $_accountid, $_accountArrayID){

		$this->clientid = $_clientid;
		$this->accountid = $_accountid;
		$this->accountArrayID= $_accountArrayID;

		$this->build();
	}

	
	function build(){

		$query = sprintf("SELECT * FROM `accounts` WHERE `accountid` = '%s'",$this->accountid);
		  	if($_SESSION['DEBUG']) echo $query . "<BR />";
		$result = mysql_query($query);
		$error = mysql_error();

		$attachmentAccountIdData = mysql_fetch_assoc($result);

		$this->accountType = $attachmentAccountIdData['accountType'];
		$this->investmentObjectives = $attachmentAccountIdData['investmentObjectives'];
		$this->percentIncome = $attachmentAccountIdData['percentIncome'];
		$this->percentBalanced = $attachmentAccountIdData['percentBalanced'];
		$this->percentGrowth = $attachmentAccountIdData['percentGrowth'];

	}



	function deleteRow(){

		$args = func_get_args();	//get all the arguments. if this is  
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

		echo "<table class=\"table\" width=\"80%\"><A id=link><TR onMouseOver=\"javascript:this.style.cursor='hand';\" onClick=\"javascript:updateAccount('" . $this->accountArrayID. "')\">";

		for($i=0;$i<$numargs;$i++){
			
			if($args[$i]){

				echo "<td class=\"$this->currentTdClass\">";
				echo $this->{$args[$i]};
				echo "</td>";
	
			}
		}

		echo "</tr></table>";
		
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

		//need to convert accountArrayID into a accountid
		$data['accountid'] = $this->accountid;
		

		//need to pull the existing note out of the database 
		$query = sprintf("SELECT * FROM `accounts` WHERE `accountid` = '%s'", $data['accountid']);
		//echo $query;

		$result = mysql_query($query);
		$accountData = $result;	
	

		$query = sprintf("UPDATE `accounts` SET 
						`accountType`		= '%s',
						`investmentObjectives`	= '%s',
						`percentIncome`		= '%s',
						`percentBalanced`	= '%s',
						`percentGrowth`		= '%s'
					WHERE `accountid` = '%s'",
						(isset($data['accountType']) ? $data['accountType'] : $accountData['accountType']),
						(isset($data['investmentObjectives']) ? $data['investmentObjectives'] : $accountData['investmentObjectives']),
						(isset($data['percentIncome']) ? $data['percentIncome'] : $accountData['percentIncome'] ),
						(isset($data['percentBalanced']) ? $data['percentBalanced'] : $accountData['percentBalanced']),
						(isset($data['percentGrowth']) ? $data['percentGrowth'] : $accountData['percentGrowth']),
						(isset($data['accountid']) ? $data['accountid'] : $accountData['accountid'])
					);
		//echo $query;
		$result = mysql_query($query);
		echo mysql_error();						
	
		//echo "The note was successfully updated. <BR />";
		//echo "<meta http-equiv=\"refresh\" content=\"2\">";
		//die();




	}


}

?>