<?php



include('includes/adminsession.php');

include('includes/adminpostclean.php');

include('includes/adminhtmlhead.php');

include('includes/adminbanner.php');



?>


<?php


$pdata = $_POST;


////// error handling
//we want to execute this whether it's the first or second run
if( isset($_POST['submit']) ){
	$error = '';
	$pdata = $_POST;

	
	//include generic $_POST cleaner
	$pdata = hash_mysql_sanitize($pdata);	
	

}
	




if(isset($pdata['notesthisclientname'])){
	$clientid = $pdata['notesthisclientname'];
}
else{
	$clientid = $pdata['clientid'];
}





if( isset($pdata['update'])){

	//process errors here, after the header is printed.
	if( $error ){
		echo "<font color=\"red\"><b>$error</b></font><BR />";
		//we just print the page like normal, if there are errors.
	}
	else{
	
		//need to pull the existing component out of the database 
		$data = mysql_fetch_array(mysql_query('SELECT * FROM notes WHERE `messageid` = "'.$pdata['message'].'"'));
	
		//insert the component data, $pdata[component] holds the ID
		mysql_query('UPDATE `blobs` SET
		`display_name` = "'.$pdata['display_name'].'", 
		`description` = "'.$pdata['description'].'", 
		`display_order` = "'.$pdata['display_order'].'"
		WHERE `blobid` = "'.$pdata['component'].'"'); 
	
		//the user was successfully created.
		echo "The component was successfully updated. <BR />";
		echo "<meta http-equiv=\"refresh\" content=\"5\">";
		die();
				
	}
	
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




echo "<H2>Notes</H2>";
	



//taint check
if( preg_match('/[^0-9A-Za-z]/',$clientid) ){
	echo "clientid  contained invalid characters! Please press the back button on your browser and attempt a different username, or contact your system administrator.";
	die();
}




//if a user has been submitted...
if( isset($clientid) ){

	echo "<H3>Notes for client: \"".$clientid."\"</H3>";
	

		/////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////THIS SHOULD BE A FUNCTION!!!! CLEAN THIS UP!!!
		//if they've submitted the "add" form
		if( isset($_POST['addsubmit']) ){
			
			//$error hasn't been used for a while, i'll reuse, terrible, I know.
			$error = '';
			
			//untaint!
			$data = $_POST;



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
			mysql_query($query);
				



			//if errors handle them
			$error = mysql_error();


			if($error){
				//if it's not all clean, output errors
	        		//and present the form again
				echo "<BR /><font color=\"red\"><b>".$error."</b></font><BR />";
				}
			else{
			
				echo "<BR />Note was added successfully.<BR />";
			}

			 
		}

	
		echo "<H3>Add New Message</H3>
	
		<form name=\"message\" action=\"adminnotes.php\" method=\"post\">
	
		<table class=\"table\" width=\"60%\">
		<tr>
		<td class=\"td1\">
		Message:
		</td>
		<td class=\"td2\">
		<input type=\"text\" name=\"messagetext\" value=\"\">
		</td>
		</tr>
		
		</table>
		
		<input type=\"hidden\" name=\"add\" value=\"add\">
		<input type=\"hidden\" name=\"clientid\" value=\"".$clientid."\">
		<input type=\"submit\" name=\"addsubmit\" value=\"Add Note\">
		</form>
		<HR />";
		



		



	////////////////////////////////// after the add section
	////////////////////////////////// Now we have to display all the notes
	//
	//echo "<table>";

	//initialize
	$notes=0;

	$query = mysql_query('SELECT * FROM `messages` WHERE `clientid` = "test"');
	$i=0; //initialize counter
	while($notes[$i]=mysql_fetch_array($query)){
		
		echo "test";
		
		echo $notes[$i];
		

	$i++; 
	}


	//echo "</table>";

}








////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////// NORMAL NOTES STUFF
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////








?>















