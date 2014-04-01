<?php


include('includes/adminsession.php');
include('includes/adminpostclean.php');


include('includes/adminhtmlhead.php');
include('includes/adminbanner.php');


include('includes/adminviewheader.php');



$pdata = $_POST;


?>

<SCRIPT>
function updateAccount(accountArrayID){	

	document.formAccountsUpdate.elements[0].value=accountArrayID;
	document.formAccountsUpdate.submit();
	document.forms["formAccountsUpdate"].submit();
	return true;
}
</SCRIPT>

<form id="formAccountsUpdate" name="formAccountsUpdate" action="adminaccounts.php" method="post">
<input type="hidden" name="accountArrayID" value="" />
<input type="hidden" name="update" value ="y" />
</form>


<?php

//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////



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
	if( isset($pdata['clientid']) ){ 
		$clientid = $pdata['clientid'];
	}
}


if( $_SESSION['clientid'] ){
	$clientid;
	$clientid = $_SESSION['clientid'];
}


//////////////////If there is no clientid yet, we need to set one.
//
if( empty($_SESSION['clientid']) ){
	$_SESSION['clientid'] = $clientid;

}






//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////



if( isset($pdata['update']) ){

	$query = sprintf("SELECT * FROM `accounts` WHERE `accountid` = '%s'", $myclient->accounts[$pdata['accountArrayID']]->accountid);
	$result = mysql_query($query);
	$data = mysql_fetch_assoc($result);

	echo "<BR /><BR />
	<form name=\"message\" action=\"adminaccounts.php\" method=\"post\">

	<table class=\"table\" width=\"70%\">
	
	<tr>
	<td class=\"td1\" >Account Type
	</td>
	<td class=\"td2\">
	<input type=\"text\" name=\"accountType\" value=\"".$data['accountType']."\">
	</td>
	</tr>
	
	<tr>
	<td class=\"td1\" width=40>Investment Objectives
	</td>
	<td class=\"td2\">
	<textarea rows=\"5\" cols=\"50\" name=\"investmentObjectives\">".$data['investmentObjectives']."
	</textarea>
	</td>
	</tr>
	
	<tr>
	<td class=\"td1\">% Income
	</td>
	<td class=\"td2\">
	<input type=\"text\" name=\"percentIncome\" value=\"".$data['percentIncome']."\">
	</td>
	</tr>
	
	<tr>
	<td class=\"td1\">% Balanced
	</td>
	<td class=\"td2\">
	<input type=\"text\" name=\"percentBalanced\" value=\"".$data['percentBalanced']."\">
	</td>
	</tr>
	
	<tr>
	<td class=\"td1\">% Income
	</td>
	<td class=\"td2\">
	<input type=\"text\" name=\"percentGrowth\" value=\"".$data['percentGrowth']."\">
	</td>
	</tr>
	
	</table>

	<input type=\"hidden\" name=\"accountArrayID\" value=\"".$pdata['accountArrayID']."\">
	
	<table class=\"table\" width=\"80%\">
	<tr>
	<td class=\"td1\" width=\"4%\">
	</td>
	<td class=\"td2\">
	<input type=\"submit\" name=\"updatesubmit\" value=\"Update Account\">
	</td>
	</tr>
	</table>

	</form>";



	


die();
}



if( isset($pdata['updatesubmit']) ){

	$myclient->accounts[$pdata['accountArrayID']]->updateRow('accountArrayID='.$pdata['accountArrayID'], 'accountType='.$pdata['accountType'], 'investmentObjectives='.$pdata['investmentObjectives'], 'percentIncome='.$pdata['percentIncome'], 'percentBalanced='.$pdata['percentBalanced'], 'percentGrowth='.$pdata['percentGrowth']);

	echo "Account updated.";

	die();
}


/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////THIS SHOULD BE A FUNCTION!!!! CLEAN THIS UP!!!
//if they've submitted the "add" form

if( isset($_POST['addsubmit']) ){
		
	//$error hasn't been used for a while, i'll reuse, terrible, I know.
	$error = '';
	
	//untaint!
	$data = $pdata;

	$query = sprintf('INSERT INTO `accounts` (
			`clientid`, 
			`accountType`, 
			`investmentObjectives`,
			`percentIncome`,
			`percentBalanced`,
			`percentGrowth`
			) VALUES ("%s", "%s", "%s", "%s", "%s", "%s")', 
			$_SESSION['clientid'],
			mysql_real_escape_string($pdata['accountType']),
			mysql_real_escape_string($pdata['investmentObjectives']),
			mysql_real_escape_string($pdata['percentIncome']),
			mysql_real_escape_string($pdata['percentBalanced']),
			mysql_real_escape_string($pdata['percentGrowth']));

	mysql_query($query);
		
	//if errors handle them
	$error = mysql_error();

	if($error){
		//if it's not all clean, output errors
       		//and present the form again
		echo "<BR /><font color=\"red\"><b>".$error."</b></font><BR />";
		}
	else{
	
		echo "<BR />Account was added successfully.<BR />";		/// THIS NEEDS TO BE A CHECK!!!!
	}
		 
}







	
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// after the add section
////////////////////////////////// Now we have to display all the accounts
//



echo "<BR /><BR /><BR />";




///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////


if(count($myclient->accounts) >= 1){
	
	for($i=0;$i<count($myclient->accounts);$i++){
		
		//these following classes and methods are stored in the "accounts" class.
		//
		if(($i % 2) == 1){
	
			$myclient->accounts[$i]->currentTdClass='td2';
			$myclient->accounts[$i]->displayRow('accountType','investmentObjectives');
		}else{
	
			$myclient->accounts[$i]->currentTdClass='td1';
			$myclient->accounts[$i]->displayRow('accountType','investmentObjectives');
		}
	
	$i++; 
	}
		

}






echo "<BR />

<BR />
<form name=\"message\" action=\"adminaccounts.php\" method=\"post\">

<table class=\"table\" width=\"70%\">

<tr>
<td class=\"td1\" >Account Type
</td>
<td class=\"td2\">
<input type=\"text\" name=\"accountType\" value=\"\">
</td>
</tr>

<tr>
<td class=\"td1\" width=40>Investment Objectives
</td>
<td class=\"td2\">
<textarea rows=\"5\" cols=\"50\" name=\"investmentObjectives\">
</textarea>
</td>
</tr>

<tr>
<td class=\"td1\">% Income
</td>
<td class=\"td2\">
<input type=\"text\" name=\"percentIncome\" value=\"\">
</td>
</tr>

<tr>
<td class=\"td1\">% Balanced
</td>
<td class=\"td2\">
<input type=\"text\" name=\"percentBalanced\" value=\"\">
</td>
</tr>

<tr>
<td class=\"td1\">% Income
</td>
<td class=\"td2\">
<input type=\"text\" name=\"percentGrowth\" value=\"\">
</td>
</tr>


</table>

<input type=\"hidden\" name=\"add\" value=\"add\">
<input type=\"hidden\" name=\"clientid\" value=\"" . $_SESSION['clientid'] . "\">
<table class=\"table\" width=\"50%\">
<tr>
<td class=\"td1\" width=\"4%\">
</td>
<td class=\"td2\">
<input type=\"submit\" name=\"addsubmit\" value=\"Add Account\">
</td>
</tr>
</table>


</form>
";



?>















