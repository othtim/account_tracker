<?php

include('includes/adminsession.php');

include('includes/adminpostclean.php');
include('includes/functions.php');


include('includes/adminhtmlhead.php');
include('includes/adminbanner.php');

//include('includes/adminviewheader.php');


?>


<SCRIPT type="text/javascript">
function submitEdit(clientname){	

	document.editthisclient.elements[0].value=clientname;
	document.editthisclient.submit();
	document.forms["editthisclientt"].submit();

	return true;
}

function submitAttachments(clientname){	

	document.attachmentsthisclient.elements[0].value=clientname;	
	document.attachmentsthisclient.submit();
	document.forms["attachmentsthisclientt"].submit();
	return true;
}

function submitNotes(clientname){	

	document.notesthisclient.elements[0].value=clientname;
	document.notesthisclient.submit();
	document.forms["notesthisclientt"].submit();
	return true;
}

function submitAccounts(clientname){	

	document.accountsthisclient.elements[0].value=clientname;
	document.accountsthisclient.submit();
	document.forms["accountsthisclientt"].submit();	
	return true;
}
</SCRIPT>


<form id="editthisclient" name="editthisclient" action="adminview.php" method="post">
<input type="hidden" name="clientid" value="" />
</form>

<form id="attachmentsthisclient" name="attachmentsthisclient" action="adminattachments.php" method="post">
<input type="hidden" name="clientid" value="" />
</form>

<form id="notesthisclient" name="notesthisclient" action="adminnotes.php" method="post">
<input type="hidden" name="clientid" value="" />
</form>

<form id="accountsthisclient" name="accountsthisclient" action="adminaccounts.php" method="post">
<input type="hidden" name="clientid" value="" />
</form>



<?php

//grab any information from submit
//	
if( isset($_POST['submit']) ){
	$error = '';
	$pdata = $_POST;
	 

	if(isset($pdata)){
		//generic post cleaner
		$pdata = hash_mysql_sanitize($pdata);
	}

}
	


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////HEADER STUFF
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if( isset($pdata['submit']) ){
	
//process errors here, after the header is printed.
if( $error ){
	echo "<font color=\"red\"><b>$error</b></font><BR />";
	//we just print the page like normal, if there are errors.
}
else{


			
}

}




//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////HTML CONTENT AREA
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$profiledata=1;




//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////we need a function here output the data in a nice way.
//
// assemble

echo "<TABLE width=90% class=table>";


	$teststring='|b=clientfirstname|b=clientlastname|n|b=clientcity|b=clientbusinessphone|';
	$cutstring = explode('|', $teststring);
	
	echo "	<TR>
		<td class=\"td1\" width=30>
		</td>";
	
	// first build the header
	for($i=0;$i < sizeof($cutstring);$i++){
	
		// we are matching a box.
		//
		if( preg_match("/^b=(.+)$/", $cutstring[$i], $matches) ){
			
			// grab the relevant name from the table
			//
			$query = sprintf("SELECT * FROM `fields` WHERE `corefieldname` = '%s' LIMIT 1", $matches[1]);
			$result = mysql_fetch_assoc(mysql_query($query));
			
			echo "<TD class=td1>";
			echo $result['displayfieldname'] . "<BR />";	
			echo "</TD>";
		}
	
	}	
	
	echo "	</TR>";


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////// CUT THIS FOR NOW
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////Then print user data
//
$query = sprintf('SELECT clientid FROM profile');
$clientdata = mysql_query($query);

//set an index.
$index=1;

//for each record, print the data in a spreadsheet style
while($clientdatarow = mysql_fetch_array($clientdata)){

	// set this for later when we go to the details panes
	//
	

	echo "<A id=link><TR onMouseOver=\"javascript:this.style.cursor='hand';\" onClick=\"javascript:submitEdit('".$clientdatarow[0]."')\">";

	if(($index % 2)==1){


		?> 

		<td class="td1" width="10%">
		<a title="Documents" href=javascript:submitAttachments('<?php echo $clientdatarow[0] ?>')><img border="0" src="images/attachments.png"></a>
		<a title="Notes" href=javascript:submitNotes('<?php echo $clientdatarow[0] ?>')><img border="0" src="images/notes.png"></a>
		<a title="Accounts" href=javascript:submitAccounts('<?php echo $clientdatarow[0] ?>')><img border="0" src="images/accounts.png"></a>
		</td>

		<?php

	}else{

		?> 

		<td class="td1" width="10%">
		<a title="Documents" href=javascript:submitAttachments('<?php echo $clientdatarow[0] ?>')><img border="0" src="images/attachments.png"></a>
		<a title="Notes" href=javascript:submitNotes('<?php echo $clientdatarow[0] ?>')><img border="0" src="images/notes.png"></a>
		<a title="Accounts" href=javascript:submitAccounts('<?php echo $clientdatarow[0] ?>')><img border="0" src="images/accounts.png"></a>
		</td>

		<?php
	}

	//then get the fields in the view
	for($iinner=0;$iinner < sizeof($cutstring);$iinner++){

		if( preg_match("/^b=(.+)$/", $cutstring[$iinner], $matches) ){
		
			if(($index % 2)==1){

				echo "<TD class=td2>";

				//grab the data

 
				$result = assembleProfileQuery($matches[1],$clientdatarow[0]);
	
				echo $result;
				echo "<BR /></TD>";
	
			}else{
				echo "<TD class=td1>";

				//grab the data
				$result = assembleProfileQuery($matches[1],$clientdatarow[0]);
	
				echo $result;
				echo "<BR /></TD>";


			}
		}

	}


	echo "</TR></A>";

	$index++;
}

echo "	</TABLE>
	<BR>";



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>




</BODY>
</HTML>










