<?php



include('includes/adminsession.php');

include('includes/adminpostclean.php');

include('includes/adminhtmlhead.php');

include('includes/adminbanner.php');



?>


<?php


	
//we want to execute this whether it's the first or second run
if( isset($_POST['submit']) || isset($_POST['submitfields']) ){
	$error = '';
	$pdata = $_POST;


	// generic post cleaner
	$pdata = hash_mysql_sanitize($pdata);

}
	

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
// to update edited fields
//
if( isset($pdata['editfields']) ){

$query = sprintf("UPDATE `fields` SET displayfieldname='%s', security='%s' WHERE corefieldname='%s'", $pdata['displayfieldname'], $pdata['security'], $pdata['corefieldname']);
$result = mysql_query($query);

//echo $query;

}	





/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( isset($pdata['submit']) ){

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////THIS FUNCTION NEEDS TO BE MADE SMARTER.
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	// to rebuild the fields table
	//
	if( isset($pdata['rebuildfields']) ){


		//declare and populate an array with the names of the columns in the profile table
		//
		$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='profile'";
		$profilecolumndata = mysql_query($query) or die(mysql_error());


		//check in fields to see what anything is there.
		$query = "SELECT corefieldname,displayfieldname,security from `fields`";
		$fielddata = mysql_query($query);


		//get the length of the profilecolumndata. fields table needs to be the same length.
		//
		if( count($profilecolumndata) != count($fielddata) ){
			echo "fields table length does not match profile table length.";
			echo count($profilecolumndata) ."   ". count($fielddata) . "<BR>";
		}

		
		//// dropping the fields table.
		//

		mysql_query('DROP TABLE `fields`;');
		mysql_query('CREATE TABLE `fields` (
			`fieldid` 		int(11) 	auto_increment NOT NULL,
			`corefieldname` 	varchar(50) 	UNIQUE NOT NULL,
			`displayfieldname` 	varchar(50) 	UNIQUE NOT NULL,
			`security` 		int(10) 	NOT NULL,
			`usersecurity`		varchar(500)	,
			PRIMARY KEY (`fieldid`)
			)' );


		//iterate through each value in the profile table
		//
		while($row = mysql_fetch_array($profilecolumndata)){
			
			echo $row[0] . "<BR>";
			

			////arrange an query. use escaped information, because we dont want taint in the DB.
			//
			$query = sprintf("INSERT INTO `fields` (corefieldname, displayfieldname, security) VALUES('%s','%s','%s')",mysql_real_escape_string($row[0]),mysql_real_escape_string($row[0]),99);	
			mysql_query($query) or die(mysql_error());
		}

		
		//tell the user what is going on
		//
		echo "The field table has been rebuilt. <BR />";
		echo "<meta http-equiv=\"refresh\" content=\"3\">";
		die();
	
	}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// UPDATE THE SETTINGS HERE//////////////////////////////////////////////////////////////////////////////////////////////



$query = sprintf('UPDATE `core` SET session_timeout=%s, message_scrubtime=%s, max_file_size=%s WHERE username="%s"',$pdata['session_timeout'], $pdata['message_scrubtime'], $pdata['max_file_size'], $_SESSION['username']);
$result = mysql_query($query);

//echo $query;
	

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//process errors here, after the header is printed.
if( $error ){
	echo "<font color=\"red\"><b>$error</b></font><BR />";
	//we just print the page like normal, if there are errors.
}







} /////////////////////////////////////////////////////////// END SUBMIT DEFINED




/////////////////////////////////////////////////////////////////CONTENT SECTION
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>


<?php $profiledata = mysql_fetch_array(mysql_query('SELECT * FROM core LIMIT 1')); ?>


<BR />

<a href="adminusers.php">Edit Users</a>
<HR />
<BR />

<form action="admincore.php" method="post">

<table class="table" width="60%">

<tr>
<td class="td1">
Session Timeout:
</td>
<td class="td2">
<input type="text" value="<?php echo $profiledata['session_timeout']; ?>" name="session_timeout"> seconds
</td>
</tr>

<tr>
<td class="td1">
Message Expiry Time:
</td>
<td class="td2">
<input type="text" value="<?php echo $profiledata['message_scrubtime']; ?>" name="message_scrubtime"> days
</td>
</tr>

<tr>
<td class="td1">
Max Upload Size:
</td>
<td class="td2">
<input type="text" value="<?php echo $profiledata['max_file_size']; ?>" name="max_file_size"> bytes
</td>
</tr>

</table>


<table width="100%">
<tr width="100%">
<td>
<input type="submit" value="Update" name="submit">
</td>
<td align="right">
<input type="checkbox" name="rebuildfields">Rebuild Fields
</td>
</tr>
</table>



</form>


<BR />
<BR />

Update fields




<?php 

//grab all of the information from the fields table.
$fieldstable = sprintf('SELECT * FROM `fields`');
$fieldstable = mysql_query($fieldstable); 

//for each record, print the field information in a spreadsheet style
while($fieldsrow = mysql_fetch_row($fieldstable)){

	echo "
	<table class=\"table\" width=\"60%\">
	<form action=\"admincore.php\" method=\"post\" name=".$fieldsrow[1].">
	<tr>
	<td class=\"td1\" width=30%>
	" . $fieldsrow[1] . "
	</td>
	<td class=\"td2\"width=30%>
	<input type=\"hidden\" value=\"" . $fieldsrow[1] . "\" name=\"corefieldname\">
	<input type=\"text\" value=\"" . $fieldsrow[2] . "\" name=\"displayfieldname\">
	</td>
	<td class=\"td2\"width=5%>
	<input type=\"text\" value=\"" . $fieldsrow[3] . "\" name=\"security\" size=5>
	</td>
	<td class=\"td2\"width=5%>";

		$query = sprintf("SELECT usersecurity FROM `fields` WHERE `corefieldname`='%s'",$fieldsrow[1]);
		$result = mysql_fetch_array(mysql_query($query));
  		
		$result = explode(',',$result[0]);

		echo "<select name=\"usersecurity\">";

		for($i=0;$i < sizeof($result);$i++){

		echo "<option>$result[$i]</option>";
		}	
		
	echo "</select>
	</td>
	<td class=\"td2\"width=30%>
	<input type=\"hidden\" value=\"yes\" name=\"editfields\">
	<input type=\"submit\" value=\"Update\" name=\"submitfields\">
	</td>
	</tr>
	</form>
	</table>
	";

}

?>



<BR />
<BR />
<BR />
<BR />

</body>
</html>


















