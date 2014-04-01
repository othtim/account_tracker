<?php



include('includes/adminpostclean.php');
include('includes/adminsession.php');

include('includes/adminhtmlhead.php');
include('includes/adminbanner.php');

//include('includes/adminviewheader.php');




//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////ERROR CHECKING////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if( !empty($_POST['submit']) && !empty($_POST['complete']) ){

	//initialize vars
	$error = '';
	$pdata = $_POST;
	$pdata = hash_mysql_sanitize($pdata);



	//
	//check if mandatory fields are empty
	//
	if( !$pdata['clientid'] ){
		$error .= "You must fill in the client ID. <BR />";
	}
	if( !$pdata['clienttype'] ){
		$error .= "You must fill in the client type. <BR />";
	}
	if( !$pdata['clientlastname'] ){
		$error .= "You must fill in the client's last name. <BR />";
	}
	if( !$pdata['clientfirstname'] ){
		$error .= "You must fill in the client's first name. <BR />";
	}

	//process errors here, after the header is printed.
	if( $error ){
		echo "<font color=\"red\"><b>$error</b></font><BR />";
		//we just print the page like normal, if there are errors.
	}
	else{

		if($_SESSION['DEBUG']) if(isset($pdata)) echo "\$pdata is set.";

		//no errors begin here.
		
		//assemble the large string
		$query = sprintf('UPDATE `profile` SET 
					`clientid`		="%s",
					`clienttype`		="%s",
					`clientdealernumber`	="%s",
					`clientadvisornumber`	="%s",
					`clientpronoun`		="%s",
					`clientlastname`	="%s",						
					`clientfirstname`	="%s",
					`clientinitial`		="%s",
					`clientaddress`		="%s",
					`clientapartment`	="%s",
					`clientcity`		="%s",
					`clientprovince`	="%s",
					`clientpostalcode`	="%s",
					`clientresidencephone`	="%s",
					`clientbusinessphone`	="%s",
					`clientssn`		="%s",
					`clientdob`		="%s",
					`clientcofirstname`	="%s",
					`clientcolastname`	="%s",
					`clientcossn`		="%s",
					`clientcodob`		="%s",
					`clientcoaddress`	="%s",
					`clientcoapartment`	="%s",
					`clientcocity`		="%s",
					`clientcoprovince`	="%s",
					`clientcopostalcode`	="%s",
					`clientmeetmethod`	="%s",
					`clientknowndate`	="%s",
					`clientknownyears`	="%s",
					`clientcitizenship`	="%s",
					`clientoccupation`	="%s",
					`clientemployer`	="%s",
					`clientemployeraddress`		="%s",
					`clientemployerbusinesstype`	="%s",
					`clientmaritalstatus`		="%s",
					`clientnumberofdependants`	="%s",
					`clientidnumber`		="%s",
					`clientidexpirydate`		="%s",
					`clientidissuecountryprovince`	="%s",
					`clientfinancialinstitution`	="%s",
					`clienttransitaccountnumber`	="%s",
					`clientcurrency`		="%s",
					`clientinvestorincome`		="%s",
					`clientinvestornetworth`	="%s",
					`clientinvestmentknowledge`	="%s",
					`clientcoinvestoroccupation`	="%s",
					`clientcoinvestoremployer`	="%s",
					`clientjointincome`		="%s",
					`clientjointnetworth`		="%s"
				WHERE `clientid`="%s"',
				mysql_real_escape_string($pdata['clientid']),
				mysql_real_escape_string($pdata['clienttype']),
				mysql_real_escape_string($pdata['clientdealernumber']),
				mysql_real_escape_string($pdata['clientadvisornumber']),
				mysql_real_escape_string($pdata['clientpronoun']),
				mysql_real_escape_string($pdata['clientlastname']),
				mysql_real_escape_string($pdata['clientfirstname']),
				mysql_real_escape_string($pdata['clientinitial']),
				mysql_real_escape_string($pdata['clientaddress']),
				mysql_real_escape_string($pdata['clientapartment']),
				mysql_real_escape_string($pdata['clientcity']),
				mysql_real_escape_string($pdata['clientprovince']),
				mysql_real_escape_string($pdata['clientpostalcode']),
				mysql_real_escape_string($pdata['clientresidencephone']),
				mysql_real_escape_string($pdata['clientbusinessphone']),
				mysql_real_escape_string($pdata['clientssn']),
				mysql_real_escape_string($pdata['clientdob']),
				mysql_real_escape_string($pdata['clientcofirstname']),
				mysql_real_escape_string($pdata['clientcolastname']),
				mysql_real_escape_string($pdata['clientcossn']),
				mysql_real_escape_string($pdata['clientcodob']),
				mysql_real_escape_string($pdata['clientcoaddress']),
				mysql_real_escape_string($pdata['clientcoapartment']),
				mysql_real_escape_string($pdata['clientcocity']),
				mysql_real_escape_string($pdata['clientcoprovince']),
				mysql_real_escape_string($pdata['clientcopostalcode']),
				mysql_real_escape_string($pdata['clientmeetmethod']),
				mysql_real_escape_string($pdata['clientknowndate']),
				mysql_real_escape_string($pdata['clientknownyears']),
				mysql_real_escape_string($pdata['clientcitizenship']),
				mysql_real_escape_string($pdata['clientoccupation']),
				mysql_real_escape_string($pdata['clientemployer']),
				mysql_real_escape_string($pdata['clientemployeraddress']),
				mysql_real_escape_string($pdata['clientemployerbusinesstype']),
				mysql_real_escape_string($pdata['clientmaritalstatus']),
				mysql_real_escape_string($pdata['clientnumberofdependants']),
				mysql_real_escape_string($pdata['clientidnumber']),
				mysql_real_escape_string($pdata['clientidexpirydate']),
				mysql_real_escape_string($pdata['clientidissuecountryprovince']),
				mysql_real_escape_string($pdata['clientfinancialinstitution']),
				mysql_real_escape_string($pdata['clienttransitaccountnumber']),
				mysql_real_escape_string($pdata['clientcurrency']),
				mysql_real_escape_string($pdata['clientinvestorincome']),
				mysql_real_escape_string($pdata['clientinvestornetworth']),
				mysql_real_escape_string($pdata['clientinvestmentknowledge']),
				mysql_real_escape_string($pdata['clientcoinvestoroccupation']),
				mysql_real_escape_string($pdata['clientcoinvestoremployer']),
				mysql_real_escape_string($pdata['clientjointincome']),
				mysql_real_escape_string($pdata['clientjointnetworth']),
				mysql_real_escape_string($pdata['clientid'])
			);
		mysql_query($query);

		$error = mysql_error();

		if($_SESSION['DEBUG']) echo $query;
		if($_SESSION['DEBUG'])  echo $error;

		//the client was successfully updated.
		
		echo "<BR />The client was successfully updated.<BR />";
		echo "<meta http-equiv=\"refresh\" content=\"3\">";
		die();
			
	}
	//no errors continues here


}
	


if( isset($_SESSION['clientid']) ){
	$clientid = $_SESSION['clientid'];
	$_SESSION['clientid'] = $clientid;
	$query = sprintf("SELECT * FROM `profile` WHERE `clientid`='%s'",mysql_real_escape_string($_SESSION['clientid']));
	$result = mysql_query($query);
	$pdata = mysql_fetch_array($result);
}

if( isset($_POST['editthisclientname']) ){
	$clientid = $_SESSION['clientid'];
	$_SESSION['clientid'] = $clientid;
	$query = sprintf("SELECT * FROM `profile` WHERE `clientid`='%s'",mysql_real_escape_string($_SESSION['clientid']));
	$result = mysql_query($query);
	$pdata = mysql_fetch_array($result);
}






//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////HTML SECTION///////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


?>



<form action="adminedit.php" method="post">




<!------------------------------------------- DEALER INFORMATION ---------------------------------!>

<table class="table" width="80%">
<tr>
<td colspan="4">
<strong>Dealer Information</strong>
</td>
</tr>

<tr>

<td class="td2">
Client ID
<BR />
<input type="text" value="<?php echo $myclient->fields['clientid'] ?>" name="clientid" size=30>
</td>

<td class="td2">
	Client Type<BR />
	<input type="radio" name="clienttype" value="individual" <?php echo $myclient->fields['clienttype']=='individual' ? 'checked':'' ?> > Individual
	<input type="radio" name="clienttype" value="joint" 	 <?php echo $myclient->fields['clienttype']=='joint' ? 'checked':'' ?> > Joint
	<BR />
	<input type="radio" name="clienttype" value="corporate"  <?php echo $myclient->fields['clienttype']=='corporate' ? 'checked':'' ?> > Corporate
	<input type="radio" name="clienttype" value="itf" 	 <?php echo $myclient->fields['clienttype']=='itf' ? 'checked':'' ?> > ITF
</td>

<td class=td2>
Dealer Number
<BR />
<input type="text" value="<?php echo $myclient->fields['clientdealernumber'] ?>" name="clientdealernumber" size="10">
</td>

<td class=td2>
Advisor Number
<BR />
<input type="text" value="<?php echo $myclient->fields['clientadvisornumber'] ?>" name="clientadvisornumber" size="10">
</td>


<td class=td2>
Form Date
<BR />
<input type="text" value="" name="clientcreatedate" size="15">
</td>

</tr>
</table>


<BR />
<BR />


<!------------------------------------- INVESTOR INFORMATION -----------------------------!>


<table class="table" width="80%">
<tr>
<td colspan="4">
<strong>Investor Information</strong>
</td>
</tr>

<tr>
<td class="td2" colspan=4>
<input type="radio" name="clientpronoun" value="Mr."	 <?php echo $myclient->fields['clientpronoun']=="Mrs" ? 'checked':'' ?> > Mr.&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientpronoun" value="Mrs."	 <?php echo $myclient->fields['clientpronoun']=="Mrs" ? 'checked':'' ?> > Mrs.&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientpronoun" value="Miss"	 <?php echo $myclient->fields['clientpronoun']=="Miss" ? 'checked':'' ?> > Miss&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientpronoun" value="Dr."	 <?php echo $myclient->fields['clientpronoun']=="Dr." ? 'checked':'' ?> > Dr.&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientpronoun" value=""	 <?php echo $myclient->fields['clientpronoun']=="" ? 'checked':'' ?> > Other
</td>
</tr>

<tr>
<td class="td2" colspan=4>
	<table class="table" cellspacing="0" cellpadding="0">
	<tr>
	<td class="td2">
	Last Name
	</td>
	<td class="td2">
	First Name
	</td>
	<td class="td2">
	Initial
	</td>
	</tr>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientlastname'] ?>" name="clientlastname" size=60>
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientfirstname'] ?>" name="clientfirstname" size=60>
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientinitial'] ?>" name="clientinitial" size=3>
	</td>
	</table>
</td>
</tr>

<tr>
<td class="td2" colspan=4>
	<table class="table" cellspacing="0" cellpadding="0">
	<tr>
	<td class="td2">
	Address
	</td>
	<td class="td2">
	Apt
	</td>
	<td class="td2">
	City
	</td>
	<td class="td2">
	Province/Territory
	</td>
	<td class="td2">
	Postal Code
	</td>
	</tr>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientaddress'] ?>" name="clientaddress" size=50>
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientapartment'] ?>" name="clientapartment" size=10>
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientcity'] ?>" name="clientcity" size=20>
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientprovince'] ?>" name="clientprovince" size=20>
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientpostalcode'] ?>" name="clientpostalcode" size=10>
	</td>
	</table>
</td>
</tr>


<tr>
<td class="td2">
Residence Phone
<input type="text" value="<?php echo $myclient->fields['clientresidencephone'] ?>" name="clientresidencephone" size=30>
</td>

<td class="td2">
Business Phone
<input type="text" value="<?php echo $myclient->fields['clientbusinessphone'] ?>" name="clientbusinessphone" size=30>
</td>

<td class="td2">
Social Insurance Number
<input type="text" value="<?php echo $myclient->fields['clientssn'] ?>" name="clientssn" size=20>
</td>

<td class="td2">
Date of Birth
<input type="text" value="<?php echo $myclient->fields['clientdob'] ?>" name="clientdob" size=20>
</td>
</tr>

</table>



<BR />
<BR />


<!------------------------------------- CO-INVESTOR INFORMATION -----------------------------!>


<table class="table" width="80%">
<tr>
<td colspan="4">
<strong>Co-Investor Information</strong>
</td>
</tr>

<tr>
<td class="td2"  colspan=3>
<input type="radio" name="clientcopronoun" value="mr"> Mr.&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientcopronoun" value="mrs"> Mrs.&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientcopronoun" value="miss"> Miss&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientcopronoun" value="dr"> Dr.&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientcopronoun" value="other"> Other
</td>
</tr>

<tr>
<td class="td2">
	<table class="table" cellspacing="0" cellpadding="0">
	<tr>
	<td class="td2">
	Last Name
	</td>
	<td class="td2">
	First Name
	</td>
	</tr>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientcofirstname'] ?>" name="clientcofirstname" size=40>
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientcolastname'] ?>" name="clientcolastname" size=40>
	</td>
	</tr>
	</table>
</td>

<td class="td2">
Social Insurance Number 
<input type="text" value="<?php echo $myclient->fields['clientcossn'] ?>" name="clientcossn" size=20>
</td>
<td class="td2">
Date of Birth 
<input type="text" value="<?php echo $myclient->fields['clientcodob'] ?>" name="clientcodob" size=20>
</td>
</tr>


<tr>
<td class="td2"  colspan=3>
	<table class="table" cellspacing="0" cellpadding="0">
	<tr>
	<td class="td2">
	Address
	</td>
	<td class="td2">
	Apt
	</td>
	<td class="td2">
	City
	</td>
	<td class="td2">
	Province/Territory
	</td>
	<td class="td2">
	Postal Code
	</td>
	</tr>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientcoaddress'] ?>" name="clientcoaddress" size=50>
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientcoapartment'] ?>" name="clientcoapartment" size=10>
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientcocity'] ?>" name="clientcocity" size=20>
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientcoprovince'] ?>" name="clientcoprovince" size=20>
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientcopostalcode'] ?>" name="clientcopostalcode" size=10>
	</td>
	</table>
</td>
</tr>

</table>



<BR />
<BR />






<!------------------------------------- KNOW YOUR CLIENT -----------------------------!>


<table class="table" width="80%">
<tr>
<td>
<strong>Know Your Client</strong>
</td>
</tr>

<tr>
<td class="td2" colspan="3">How did you meet?&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientmeetmethod" value="Referral"		<?php echo $myclient->fields['clientmeetmethod']=='Referral' ? 'checked':'' ?> > Referral&nbsp;&nbsp;
<input type="radio" name="clientmeetmethod" value="Personal Contact"	<?php echo $myclient->fields['clientmeetmethod']=='Personal Contact' ? 'checked':'' ?> Personal Contact&nbsp;&nbsp;
<input type="radio" name="clientmeetmethod" value="Seminar"		<?php echo $myclient->fields['clientmeetmethod']=='Seminar' ? 'checked':'' ?> > Seminar&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientmeetmethod" value="Advertising"		<?php echo $myclient->fields['clientmeetmethod']=='Advertising' ? 'checked':'' ?> > Advertising&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientmeetmethod" value="Phone In"		<?php echo $myclient->fields['clientmeetmethod']=='Phone In' ? 'checked':'' ?> > Phone In&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientmeetmethod" value="Walk In"		<?php echo $myclient->fields['clientmeetmethod']=='Walk In' ? 'checked':'' ?> > Walk In
</td>
</tr>


<tr>
<td class="td2" colspan="2">
Known Client Since:&nbsp;&nbsp; <input type="text" value="<?php echo $myclient->fields['clientknowndate'] ?>" name="clientknowndate" size=20>
&nbsp;&nbsp; or &nbsp;&nbsp;&nbsp;<input type="text" value="<?php echo $myclient->fields['clientknownyears'] ?>" name="clientknownyears" size=4> &nbsp;&nbsp;years
</td>
<td class="td2">
Investor Citizenship <input type="text" value="<?php echo $myclient->fields['clientcitizenship'] ?>" name="clientcitizenship" size=10>
<BR />
</td>
</tr>


<tr>
<td class="td2" colspan="2">
Investor Occupation
<input type="text" value="<?php echo $myclient->fields['clientoccupation'] ?>" name="clientoccupation" size=30>
</td>
<td class="td2">
Investor Employer
<input type="text" value="<?php echo $myclient->fields['clientemployer'] ?>" name="clientemployer" size=40>
</td>
</tr>


<tr>
<td class="td2" colspan="2">
Employer Address
<input type="text" value="<?php echo $myclient->fields['clientemployeraddress'] ?>" name="clientemployeraddress" size=40>
</td>
<td class="td2">
Business Type
<input type="text" value="<?php echo $myclient->fields['clientemployerbusinesstype'] ?>" name="clientemployerbusinesstype" size=50>
</td>
</tr>


<tr>
<td class="td2" colspan="3">Marital Status&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientmaritalstatus" value="Single"		<?php echo $myclient->fields['clientmaritalstatus']=='Single' ? 'checked':'' ?> > Single&nbsp;&nbsp;
<input type="radio" name="clientmaritalstatus" value="Married"		<?php echo $myclient->fields['clientmaritalstatus']=='Married' ? 'checked':'' ?> > Married&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientmaritalstatus" value="Common Law"	<?php echo $myclient->fields['clientmaritalstatus']=='Common Law' ? 'checked':'' ?> > Common Law&nbsp;&nbsp;
<input type="radio" name="clientmaritalstatus" value="Seperated"	<?php echo $myclient->fields['clientmaritalstatus']=='Seperated' ? 'checked':'' ?> > Seperated&nbsp;&nbsp;
<input type="radio" name="clientmaritalstatus" value="Divorced"		<?php echo $myclient->fields['clientmaritalstatus']=='Divorced' ? 'checked':'' ?> > Divorced&nbsp;&nbsp;
<input type="radio" name="clientmaritalstatus" value="Widowed"		<?php echo $myclient->fields['clientmaritalstatus']=='Widowed' ? 'checked':'' ?> > Widowed
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
Number of Dependants <input type="text" value="<?php echo $myclient->fields['clientnumberofdependants'] ?>" name="clientnumberofdependants" size=4>
</td>
</tr>


<tr>
<td class="td2" colspan="3">ID Verification (check one)&nbsp;&nbsp;&nbsp;
<input type="radio" name="clientidverification" value="Passport"> Passport
<input type="radio" name="clientidverification" value="Birth Certificate"> Birth Certificate
<input type="radio" name="clientidverification" value="Drivers License"> Driver's License
<input type="radio" name="clientidverification" value="Immigration Card"> Immigration Card
<input type="radio" name="clientidverification" value="Other"> Other 
</td>
</tr>


<tr>
<td class="td2">
ID Number
<input type="text" value="<?php echo $myclient->fields['clientidnumber'] ?>" name="clientidnumber" size=40>
</td>
<td class="td2">
ID Expiry Date
<input type="text" value="<?php echo $myclient->fields['clientidexpirydate'] ?>" name="clientidexpirydate" size=50>
</td>
<td class="td2">
ID Issue Country/Province
<input type="text" value="<?php echo $myclient->fields['clientidissuecountryprovince'] ?>" name="clientidissuecountryprovince" size=50>
</td>
</tr>


<tr>
<td class="td2">
Financial Institution
<input type="text" value="<?php echo $myclient->fields['clientfinancialinstitution'] ?>" name="clientfinancialinstitution" size=40>
</td>
<td class="td2">
Transit# / Account#
<input type="text" value="<?php echo $myclient->fields['clienttransitaccountnumber'] ?>" name="clienttransitaccountnumber" size=50>
</td>
<td class="td2">
Currency
<input type="text" value="<?php echo $myclient->fields['clientcurrency'] ?>" name="clientcurrency" size=50>
</td>
</tr>


<tr>
<td class="td2">
Investor Income
<input type="text" value="<?php echo $myclient->fields['clientinvestorincome'] ?>" name="clientinvestorincome" size=40>
</td>
<td class="td2">
Investor Net Worth
<input type="text" value="<?php echo $myclient->fields['clientinvestornetworth'] ?>" name="clientinvestornetworth" size=50>
</td>
<td class="td2" colspan="3">Investment Knowledge (check one)&nbsp;&nbsp;&nbsp;<BR />
<input type="radio" name="clientinvestmentknowledge" value="Sophisticated" 	<?php echo $myclient->fields['clientinvestmentknowledge']=='Sophisticated' ? 'checked':'' ?> > Sophisticated
<input type="radio" name="clientinvestmentknowledge" value="Good"		<?php echo $myclient->fields['clientinvestmentknowledge']=='Good' ? 'checked':'' ?> > Good
<input type="radio" name="clientinvestmentknowledge" value="Fair"		<?php echo $myclient->fields['clientinvestmentknowledge']=='Fair' ? 'checked':'' ?> > Fair
<input type="radio" name="clientinvestmentknowledge" value="Poor"		<?php echo $myclient->fields['clientinvestmentknowledge']=='Poor' ? 'checked':'' ?> > Poor
</td>
</tr>

<tr>
<td class="td2"  colspan=3>
	<table class="table" cellspacing="0" cellpadding="0">
	<tr>
	<td class="td2">
	Joint Investor Occupation 
	</td>
	<td class="td2">
	Joint Investor Employer 
	</td>
	<td class="td2">
	Joint Income
	</td>
	<td class="td2">
	Joint Net Worth
	</td>
	</tr>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientcoinvestoroccupation'] ?>" name="clientcoinvestoroccupation" size=50>
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientcoinvestoremployer'] ?>" name="clientcoinvestoremployer" size=40>
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientjointincome'] ?>" name="clientjointincome" size=20>
	</td>
	<td class="td2">
	<input type="text" value="<?php echo $myclient->fields['clientjointnetworth'] ?>" name="clientjointnetworth" size=20>
	</td>
	</table>
</td>
</tr>


</table>



<BR />
<BR />
<BR />


<table class="table" width="80%">
<tr>
<td>
<strong>Complete</strong>
</td>
</tr>

<tr>
<td class="td2">
<input type="checkbox" name="complete" value="complete">
</td>
</tr>
</table>




<BR />


<input type="submit" value="Update Profile" name="submit"><BR />
</form>








<BR />
<BR />
<BR />
<BR />
<BR />
<BR />
<BR />













