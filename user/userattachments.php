<?php



include('includes/usersession.php');
include('includes/userpostclean.php');

include('includes/userhtmlhead.php');
include('includes/userbanner.php');

include('includes/userviewheader.php');


///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
//// added this section because I wanted to include this function inline until I've got it worked out.
?>

<SCRIPT>
function viewAttachment(blobid){
	document.viewattachment.elements[0].value=blobid;
	document.viewattachment.submit();
	document.forms["viewattachment"].submit();
	return true;
}
</SCRIPT>

<form id="viewattachment" name="viewattachment" action="userattachments.php" method="post">
<input type="hidden" name="blobid" value="" />
</form>

<?php
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

echo "<BR /><BR />";


$pdata = $_POST;
$error = '';




////// error handling
//we want to execute this whether it's the first or second run
if( isset($_POST['submit']) ){
	$error = '';
	$pdata = $_POST;

	//include generic $_POST cleaner
	$pdata = hash_mysql_sanitize($pdata);	
	

}
	


//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////




if(isset($pdata['attachmentsthisclientname'])){
	$clientid = $pdata['attachmentsthisclientname'];
	$_SESSION['clientid'] = $clientid;
	
}
else{
	if( isset($pdata['clientid']) ){ 
		$clientid = $pdata['clientid'];
		$_SESSION['clientid'] = $clientid;
	}
}


if( $_SESSION['clientid'] ){
	$clientid = $_SESSION['clientid'];
	$_SESSION['clientid'] = $clientid;
}





//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////



if( isset($pdata['update'])){

	//process errors here, after the header is printed.
	if( $error ){
		echo "<font color=\"red\"><b>$error</b></font><BR />";
		//we just print the page like normal, if there are errors.
	}
	else{
	
		//need to pull the existing component out of the database 
		$data = mysql_fetch_array(mysql_query('SELECT * FROM blobs WHERE `blobid` = "'.$pdata['blobid'].'"'));
	
		//insert the component data, $pdata[component] holds the ID
		$query = sprintf('UPDATE `blobs` SET
					`display_name` = "%s", 
					`description` = "%s", 
					`display_order` = 1
					WHERE `blobid` = "%s"', 
					$pdata['display_name'],
					$pdata['description'],
					$pdata['blobid']		
					); 
		mysql_query($query);	



		//the user was successfully created.
		echo "<BR />The attachment was successfully updated. <BR />";
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


	
//add components
if( isset($_POST['add']) ){

	//if they've submitted the "add" form
	if( isset($_POST['addsubmit']) ){
			
		//$error hasn't been used for a while, we'll reuse, terrible, I know.
		$error = '';
			
		//untaint!
		$data = $_POST;

		//we aren't going to check this for invalid chars.
		//just mysql_real_escape_string() it :)
		$files = $_FILES; 

		//if( ($value == '') || ($value == NULL) ){
		//	$error .= "Some fields were empty. <BR />";
		//}

			
		//check stuff
		//if everything is clean, we'll move on
		if( !($error) ){
		
			//do the file upload stuff
			$fileName = $_FILES['userfile']['name'];
			$tmpName = $_FILES['userfile']['tmp_name'];
			$fileSize = $_FILES['userfile']['size'];
			$fileType = $_FILES['userfile']['type'];

			echo $tmpName;

			$target_path = "uploads/";
			$target_path = $target_path . basename($fileName) . mt_rand(); 

			if(move_uploaded_file($tmpName, $target_path)) {
    				

				$query = sprintf(	"INSERT INTO `blobs` (clientid, display_name, description, display_order, name, type, size, path) 
							VALUES('%s', '%s', '%s', '%s','%s', '%s', '%s', '%s')",
							$clientid,
							mysql_real_escape_string($data['display_name']),
							mysql_real_escape_string($data['description']),
							1,
							mysql_real_escape_string($fileName),
							mysql_real_escape_string($fileType),
							mysql_real_escape_string($fileSize),
							mysql_real_escape_string($target_path) );
				$result = mysql_query($query);
	
				echo "The file ".  basename($fileName). " has been uploaded";


			} else{
    				echo "There was an error uploading ".  basename($fileName). ", please try again!";
			}



			die();
		}
		else{

			//if it's not all clean, output errors
		        //and present the form again
			echo "<BR /><font color=\"red\"><b>".$error."</b></font><BR />";
		}
			 
	}
	
	echo "<H3>Add New Document</H3>";
	
	echo "<form action=\"userattachments.php\" enctype=\"multipart/form-data\" method=\"post\">

	<table class=\"table\" width=\"60%\">

	<tr>
	<td class=\"td1\">
	Display Name:
	</td>
	<td class=\"td2\">
	<input type=\"text\" name=\"display_name\" value=\"\">
	</td>
	</tr>

	<tr>
	<td class=\"td1\">
	Description:
	</td>
	<td class=\"td2\">
	<input type=\"text\" name=\"description\" value=\"\">
	</td>
	</tr>
	max_file_size
	<tr>
	<td class=\"td1\">
	Link:
	</td>
	<td class=\"td2\">
	<input type=\"file\" name=\"userfile\" id=\"userfile\" value=\"\">
	</td>
	</tr>

	</table>
		
	<input type=\"hidden\" name=\"add\" value=\"add\">
	<input type=\"hidden\" name=\"clientid\" value=\"".$clientid."\">
	<input type=\"submit\" name=\"addsubmit\" value=\"Add Document\">
	</form>";
		
	die();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//only show the details if a component has been selected. also, only show editable details if this is the creator.
//
if( isset($pdata['blobid']) ){

	
	// UNTAINT THIS LATER
	// fetch the data to populate this section
	$query = sprintf("SELECT * FROM `blobs` WHERE `blobid`='%s'",$pdata['blobid']);
	$componentdata = mysql_fetch_array(mysql_query($query));

	// next we need to get the creator of this attachment. compare the clientid from `blobs` to the clientid from `profile`. on match, check creator field in profile.
	//
	$security_thisBlobsClientID = mysql_fetch_array(mysql_query(sprintf("SELECT `clientid` FROM `blobs` WHERE `blobid`='%s'", $pdata['blobid'])));
	$security_thisProfileCreator = mysql_fetch_array(mysql_query(sprintf("SELECT `creator` FROM `profile` WHERE `clientid`='%s'", $security_thisBlobsClientID[0])));	

	if($security_thisProfileCreator[0] == $_SESSION['username']){

	?>	

	<form action="userattachments.php" method="post">

	<input type="hidden" name="blobid" value="<?php echo $pdata['blobid'] ?>">
	
	<HR />
	
	<table class="table" width="60%">

	<tr>
	<td class="td1">	
	Display Name:
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $componentdata['display_name']; ?>" name="display_name">
	</td>
	</tr>

	<tr>
	<td class="td1">
	Description:
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $componentdata['description']; ?>" name="description">
	</td>
	</tr>

	<tr>
	<td class="td1">
	Display Order:
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $componentdata['display_order']; ?>" name="display_order">
	</td>
	</tr>
	
	<tr>
	<td colspan="2"></td>
	</tr>
	
	<tr>
	<td class="td1">
	Type:
	</td>
	<td class="td2"><?php echo $componentdata['type']; ?></td>
	</tr>
	<input type="hidden" value="20000000000000000" name="MAX_FILE_SIZE">
	<tr>
	<td class="td1">
	File:
	</td>
	<td class="td2">
	<a href="download.php?downloadid=<?php echo $pdata['blobid']; ?>"> Download this file. (<?php echo $componentdata['display_name']; ?>)</a> 
	</td>
	</tr>
	
	<tr>
	<td class="td1">
	Filesize:
	</td>
	<td class="td2"><?php echo $componentdata['size']; ?></td>
	</tr>
	</table>
	
	<input type="submit" value="Update" name="update">
	</form>

	<?php


	// if the current user is not the creator, they get a locked version of the attachments window.
	}else{

	?>

	<form>

	<input type="hidden" name="blobid" value="<?php echo $pdata['blobid'] ?>">

	<HR />

	
	<table class="table" width="60%">

	<tr>
	<td class="td1">	
	Display Name:
	</td>
	<td class="td2">
	<?php echo $componentdata['display_name']; ?>
	</td>
	</tr>

	<tr>
	<td class="td1">
	Description:
	</td>
	<td class="td2">
	<?php echo $componentdata['description']; ?>
	</td>
	</tr>

	<tr>
	<td class="td1">
	Display Order:
	</td>
	<td class="td2">
	<?php echo $componentdata['display_order']; ?>
	</td>
	</tr>
	
	<tr>
	<td colspan="2"></td>
	</tr>
	
	<tr>
	<td class="td1">
	Type:
	</td>
	<td class="td2"><?php echo $componentdata['type']; ?></td>
	</tr>
	<input type="hidden" value="20000000000000000" name="MAX_FILE_SIZE">
	<tr>
	<td class="td1">
	File:
	</td>
	<td class="td2">
	<a href="download.php?downloadid=<?php echo $pdata['blobid']; ?>"> Download this file. (<?php echo $componentdata['display_name']; ?>)</a> 
	</td>
	</tr>
	
	<tr>
	<td class="td1">
	Filesize:
	</td>
	<td class="td2"><?php echo $componentdata['size']; ?></td>
	</tr>
	</table>
	
	</form>

	<?php


	}

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
// now we need to pull all of the components out
// components is a multidimensional array holding the component records
// we will use the unique `id` to identify record to edit
//


if(count($myclient->attachments) >= 1){

	for($i=0; $i < count($myclient->attachments) ; $i++){
	
		//these following classes and methods are stored in the "attachment" class.
		//
		if( ($i % 2) == 1){
	
			$myclient->attachments[$i]->currentTdClass='td2';
			$myclient->attachments[$i]->displayRow('icon','display_name','description','name','delete');
		}else{
	
			$myclient->attachments[$i]->currentTdClass='td1';
			$myclient->attachments[$i]->displayRow('icon','display_name','description','name','delete');
		}
	
	}	


}


//give the user the option to add a new component to this client
echo "<form name=\"addform\" action=\"userattachments.php\" method=\"post\">
<input type=\"hidden\" name=\"add\" value=\"add\">
<input type=\"hidden\" name=\"clientid\" value=\"".$clientid."\">
<table class=\"table\" width=\"80%\">
<tr>
<td class=\"td1\" width=\"4%\">
</td>
<td class=\"td2\">
<input type=\"submit\" name=\"add\" value=\"Add New Attachment\">
</td>
</tr>
</table>
</form>";














