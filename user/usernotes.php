<?php


include('includes/usersession.php');
include('includes/userpostclean.php');


include('includes/userhtmlhead.php');
include('includes/userbanner.php');


include('includes/userviewheader.php');



$pdata = $_POST;




/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
?>

<SCRIPT>
function updateNote(messageArrayID){	

	document.formNotesUpdate.elements[0].value=messageArrayID;
	document.formNotesUpdate.submit();
	document.forms["formNotesUpdate"].submit();
	return true;
}
</SCRIPT>

<form id="formNotesUpdate" name="formNotesUpdate" action="usernotes.php" method="post">
<input type="hidden" name="messageArrayID" value="" />
<input type="hidden" name="update" value ="" />
</form>

<?php

/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////



////// error handling and cleanup
//we want to execute this whether it's the first or second run
if( isset($_POST['submit']) ){
	$error = '';
	$pdata = $_POST;

	
	//include generic $_POST cleaner
	$pdata = hash_mysql_sanitize($pdata);	
	

}
	

/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////deal with $clientid


if(isset($pdata['notesthisclientname'])){
	$clientid = $pdata['notesthisclientname'];
	
}
else{
	if( isset($pdata['clientid']) ){ 
		$clientid = $pdata['clientid'];
	}
}



//////////////////If there is no clientid yet, we need to set one.
//
if( empty($_SESSION['clientid']) ){
	$_SESSION['clientid'] = $clientid;

}

if( isset($_SESSION['clientid']) ){
	$clientid = $_SESSION['clientid'];		
}


//taint check
if( preg_match('/[^0-9A-Za-z]/',$clientid) ){
	echo "clientid  contained invalid characters! Please press the back button on your browser and attempt a different username, or contact your system administrator.";
	die();
}



/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////


if( isset($pdata['add']) ){
	
	//$error hasn't been used for a while, i'll reuse, terrible, I know.
	$error = '';
	
	//untaint!
	$pdata = $_POST;

	$query = sprintf('INSERT INTO `messages` (
			`clientid`, 
			`message`, 
			`date`, 
			`creator`,
			`security`) VALUES ("%s", "%s", "%s", "%s", "%s")', 
			$clientid,
			mysql_real_escape_string($pdata['messagetext']),
			date('Y-m-d H:i:s'),
			$_SESSION['username'],
			99 );

	$result = mysql_query($query);

	$error = mysql_error();

	if($error){

		echo "<BR /><font color=\"red\"><b>".$error."</b></font><BR />";
	}
	else{
	
		echo "<BR />Note was added successfully.<BR />";
	}
		 
}

	
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////


if( isset($pdata['update']) ){

	$query = sprintf("SELECT * FROM `messages` WHERE `messageid` = '%s'", $myclient->notes[$pdata['messageArrayID']]->messageid);
	$result = mysql_query($query);
	$data = mysql_fetch_assoc($result);

	// check the security on this field. if the current user is not the creator, they get read-only on this note.
	if( $data['creator'] == $_SESSION['username'] ){

		echo "
		<BR />
		<BR />
		<form name=\"message\" action=\"usernotes.php\" method=\"post\">
	
		<table class=\"table\" width=\"80%\">
		<tr>
		<td class=\"td1\">
		<input type=\"text\" name=\"date\" value=\"".$data['date']."\">
		</td>
		</tr>
		<tr>
		<td class=\"td1\">
		<textarea rows=\"5\" cols=\"90\" name=\"message\">".$data['message']."
		</textarea>
		</td>
		</tr>
		
		</table>
	
		<input type=\"hidden\" name=\"messageArrayID\" value=\"".$pdata['messageArrayID']."\">
		
		<table class=\"table\" width=\"80%\">
		<tr>
		<td class=\"td1\" width=\"4%\">
		</td>
		<td class=\"td2\">
		<input type=\"submit\" name=\"updatesubmit\" value=\"Update Note\">
		</td>
		</tr>
		</table>
	
		</form>
	
		<HR />";

	// if they are not this notes creator, the current user gets a locked version.
	}else{

		echo "
		<BR />
		<BR />
		<form name=\"message\" action=\"usernotes.php\" method=\"post\">
	
		<font size=\"-1\">locked</font>
		<table class=\"table\" width=\"80%\">
		<tr><td class=\"td1\" style=\"background-color:lightgray\">".$data['date']."</td></tr>
		<tr><td class=\"td2\">".$data['message']."</td></tr>
		</table>
	
		</form>
	
		<HR />";
	}


	if(count($myclient->notes) >= 1){
		
		for($i=0;$i<count($myclient->notes);$i++){
	
			$myclient->notes[$i]->currentTdClass='td1';
			$myclient->notes[$i]->displayRow('icon','date','creator');
			$myclient->notes[$i]->currentTdClass='td2';
			$myclient->notes[$i]->displayRow('message');
			
			echo "<BR />";
	
		}
	
	}
	die();
}



if( isset($pdata['updatesubmit']) ){

	$myclient->notes[$pdata['messageArrayID']]->updateRow('messageArrayID='.$pdata['messageArrayID'], 'message='.$pdata['message'],'date='.$pdata['date'], 'creator='.$_SESSION['username']);

	die();
}

/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

////Default display if none of the others are set. must figure out a better way to do this.



	echo "<BR />
	<BR />
	<form name=\"message\" action=\"usernotes.php\" method=\"post\">

	<table class=\"table\" width=\"80%\">
	<tr>
	<td class=\"td1\">
	<textarea rows=\"5\" cols=\"90\" name=\"messagetext\">
	</textarea>
	</td>
	</tr>
	
	</table>
	
	<input type=\"hidden\" name=\"add\" value=\"add\">


	<table class=\"table\" width=\"80%\">
	<tr>
	<td class=\"td1\" width=\"4%\">
	</td>
	<td class=\"td2\">
	<input type=\"submit\" name=\"add\" value=\"Add Note\">
	</td>
	</tr>
	</table>

	</form>

	<HR />";
	



if(count($myclient->notes) >= 1){
	
	for($i=0;$i<count($myclient->notes);$i++){

		$myclient->notes[$i]->currentTdClass='td1';
		$myclient->notes[$i]->displayRow('icon','date','creator');
		$myclient->notes[$i]->currentTdClass='td2';
		$myclient->notes[$i]->displayRow('message');
		
		echo "<BR />";

	}

}


//if(count($myclient->notes) >= 1){
//	
///	for($i=0;$i<count($myclient->notes);$i++){
//		
//		//these following classes and methods are stored in the "notes" class.
//		//
//		if(($i % 2) == 1){
//	
//			$myclient->notes[$i]->currentTdClass='td2';
//			$myclient->notes[$i]->displayRow('icon','date','message','creator','security');
//
//		}else{
//	
//			$myclient->notes[$i]->currentTdClass='td1';
//			$myclient->notes[$i]->displayRow('icon','date','message','creator','security');
//		}
//	
//	$i++; 
//	}
//		
//
//}






//////formatting is off.




?>















