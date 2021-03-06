<?php

include('includes/adminsession.php');

include('includes/adminpostclean.php');

include('includes/adminhtmlhead.php');

include('includes/adminbanner.php');



?>


<?php


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



	//check if a user with that clientname already exists
	if( mysql_num_rows( mysql_query('SELECT * FROM `profile` WHERE `clientid` = "'.mysql_real_escape_string($pdata['clientid']).'"') ) ){
		$error .= "The company \"".$pdata['clientid']."\" already exists! <BR />";
	}


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

}
	


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////CREATE PROFILE//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




if( !empty($_POST['submit']) && !empty($_POST['complete']) ){

	//process errors here, after the header is printed.
	if( $error ){
		echo "<font color=\"red\"><b>$error</b></font><BR />";
		//we just print the page like normal, if there are errors.
	}
	else{

	//no errors begin here.
		
		//assemble the large string
		$query = sprintf('
				INSERT INTO `profile` (
					`clientid`,
					`clienttype`,
					`clientdealernumber`,
					`clientadvisornumber`,
					`clientpronoun`,
					`clientlastname`,							
					`clientfirstname`,
					`clientinitial`,
					`clientaddress`,
					`clientapartment`,
					`clientcity`,
					`clientprovince`,
					`clientpostalcode`,
					`clientresidencephone`,
					`clientbusinessphone`,
					`clientssn`,
					`clientdob`,
					`clientcofirstname`,
					`clientcolastname`,
					`clientcossn`,
					`clientcodob`,
					`clientcoaddress`,
					`clientcoapartment`,
					`clientcocity`,
					`clientcoprovince`,
					`clientcopostalcode`,
					`clientmeetmethod`,
					`clientknowndate`,
					`clientknownyears`,
					`clientcitizenship`,
					`clientoccupation`,
					`clientemployer`,
					`clientemployeraddress`,
					`clientemployerbusinesstype`,
					`clientmaritalstatus`,
					`clientnumberofdependants`,
					`clientidnumber`,
					`clientidexpirydate`,
					`clientidissuecountryprovince`,
					`clientfinancialinstitution`,
					`clienttransitaccountnumber`,
					`clientcurrency`,
					`clientinvestorincome`,
					`clientinvestornetworth`,
					`clientinvestmentknowledge`,
					`clientcoinvestoroccupation`,
					`clientcoinvestoremployer`,
					`clientjointincome`,
					`clientjointnetworth`,
					`creator`,
					`usersecurity`
				) 
				VALUES("%s","%s","%s","%s","%s","%s","%s","%s","%s","%s",
					"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s",
					"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s",
					"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s",
					"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s",
					"%s"
				)',
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
				$_SESSION['username'],
				''
			);

		mysql_query($query);
		echo mysql_error();

		//the user was successfully created.
		
		echo "The user was successfully created. <BR />";
		echo "<meta http-equiv=\"refresh\" content=\"3\">";
		die();
			
	}


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


//to avoid errors related to pdata not being set. 
if( !isset($pdata) ){
	$pdata=0;
}



echo "<form action=\"admincreate.php\" method=\"post\">

<h2>Create Account</h2>






<!------------------------------------------- DEALER INFORMATION ---------------------------------!>

<table class=\"table\" width=\"80%\">
<tr>
<td colspan=\"4\">
<strong>Dealer Information</strong>
</td>
</tr>

<tr>

<td class=\"td2\">
Client ID
<BR />
<input type=\"text\" value=\"".$pdata['clientid']."\" name=\"clientid\" size=30>
</td>

<td class=\"td2\">
	<table class=table cellspacing=0 cellpadding=0>
	<td class=\"td2\">
	Client Type
	</td>
	<td class=\"td2\">
	<input type=\"hidden\" name=\"clienttype\" value=\"\">
	<input type=\"radio\" name=\"clienttype\" value=\"individual\"> Individual
	<input type=\"radio\" name=\"clienttype\" value=\"joint\"> Joint
	<BR />
	<input type=\"radio\" name=\"clienttype\" value=\"corporate\"> Corporate
	<input type=\"radio\" name=\"clienttype\" value=\"itf\"> ITF
	</td>
	</table>
</td>

<td class=td2>
Dealer Number
<BR />
<input type=\"text\" value=\"".$pdata['clientdealernumber']."\" name=\"clientdealernumber\" size=\"10\">
</td>

<td class=td2>
Advisor Number
<BR />
<input type=\"text\" value=\"".$pdata['clientadvisornumber']."\" name=\"clientadvisornumber\" size=\"10\">
</td>

<td class=td2>
Form Date
<BR />
<input type=\"text\" value=\"".$pdata['clientcreatedate']."\" name=\"clientcreatedate\" size=\"15\">
</td>

</tr>
</table>


<BR />
<BR />


<!------------------------------------- INVESTOR INFORMATION -----------------------------!>


<table class=\"table\" width=\"80%\">
<tr>
<td colspan=\"4\">
<strong>Investor Information</strong>
</td>
</tr>

<tr>
<td class=\"td2\" colspan=4>
<input type=\"radio\" name=\"clientpronoun\" value=\"Mr.\"> Mr.&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientpronoun\" value=\"Mrs.\"> Mrs.&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientpronoun\" value=\"Miss\"> Miss&nbsp;&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientpronoun\" value=\"Dr.\"> Dr.&nbsp;&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientpronoun\" value=\"\"> Other
</td>
</tr>

<tr>
<td class=\"td2\" colspan=4>
	<table class=\"table\" cellspacing=\"0\" cellpadding=\"0\">
	<tr>
	<td class=\"td2\">
	Last Name
	</td>
	<td class=\"td2\">
	First Name
	</td>
	<td class=\"td2\">
	Initial
	</td>
	</tr>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientlastname']."\" name=\"clientlastname\" size=60>
	</td>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientfirstname']."\" name=\"clientfirstname\" size=60>
	</td>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientinitial']."\" name=\"clientinitial\" size=3>
	</td>
	</table>
</td>
</tr>

<tr>
<td class=\"td2\" colspan=4>
	<table class=\"table\" cellspacing=\"0\" cellpadding=\"0\">
	<tr>
	<td class=\"td2\">
	Address
	</td>
	<td class=\"td2\">
	Apt
	</td>
	<td class=\"td2\">
	City
	</td>
	<td class=\"td2\">
	Province/Territory
	</td>
	<td class=\"td2\">
	Postal Code
	</td>
	</tr>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientaddress']."\" name=\"clientaddress\" size=50>
	</td>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientapartment']."\" name=\"clientapartment\" size=10>
	</td>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientcity']."\" name=\"clientcity\" size=20>
	</td>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientprovince']."\" name=\"clientprovince\" size=20>
	</td>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientpostalcode']."\" name=\"clientpostalcode\" size=10>
	</td>
	</table>
</td>
</tr>


<tr>
<td class=\"td2\">
Residence Phone
<input type=\"text\" value=\"".$pdata['clientresidencephone']."\" name=\"clientresidencephone\" size=30>
</td>

<td class=\"td2\">
Business Phone
<input type=\"text\" value=\"".$pdata['clientbusinessphone']."\" name=\"clientbusinessphone\" size=30>
</td>

<td class=\"td2\">
Social Insurance Number
<input type=\"text\" value=\"".$pdata['clientssn']."\" name=\"clientssn\" size=20>
</td>

<td class=\"td2\">
Date of Birth
<input type=\"text\" value=\"".$pdata['clientdob']."\" name=\"clientdob\" size=20>
</td>
</tr>

</table>



<BR />
<BR />

<!------------------------------------- CO-INVESTOR INFORMATION -----------------------------!>


<table class=\"table\" width=\"80%\">
<tr>
<td colspan=\"4\">
<strong>Co-Investor Information</strong>
</td>
</tr>

<tr>
<td class=\"td2\"  colspan=3>
<input type=\"radio\" name=\"clientcopronoun\" value=\"mr\"> Mr.&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientcopronoun\" value=\"mrs\"> Mrs.&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientcopronoun\" value=\"miss\"> Miss&nbsp;&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientcopronoun\" value=\"dr\"> Dr.&nbsp;&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientcopronoun\" value=\"other\"> Other
</td>
</tr>

<tr>
<td class=\"td2\">
	<table class=\"table\" cellspacing=\"0\" cellpadding=\"0\">
	<tr>
	<td class=\"td2\">
	Last Name
	</td>
	<td class=\"td2\">
	First Name
	</td>
	</tr>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientcofirstname']."\" name=\"clientcofirstname\" size=40>
	</td>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientcolastname']."\" name=\"clientcolastname\" size=40>
	</td>
	</tr>
	</table>
</td>

<td class=\"td2\">
Social Insurance Number 
<input type=\"text\" value=\"".$pdata['clientcossn']."\" name=\"clientcossn\" size=20>
</td>
<td class=\"td2\">
Date of Birth 
<input type=\"text\" value=\"".$pdata['clientcodob']."\" name=\"clientcodob\" size=20>
</td>
</tr>


<tr>
<td class=\"td2\"  colspan=3>
	<table class=\"table\" cellspacing=\"0\" cellpadding=\"0\">
	<tr>
	<td class=\"td2\">
	Address
	</td>
	<td class=\"td2\">
	Apt
	</td>
	<td class=\"td2\">
	City
	</td>
	<td class=\"td2\">
	Province/Territory
	</td>
	<td class=\"td2\">
	Postal Code
	</td>
	</tr>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientcoaddress']."\" name=\"clientcoaddress\" size=50>
	</td>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientcoapartment']."\" name=\"clientcoapartment\" size=10>
	</td>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientcocity']."\" name=\"clientcocity\" size=20>
	</td>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientcoprovince']."\" name=\"clientcoprovince\" size=20>
	</td>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientcopostalcode']."\" name=\"clientcopostalcode\" size=10>
	</td>
	</table>
</td>
</tr>

</table>



<BR />
<BR />






<!------------------------------------- KNOW YOUR CLIENT -----------------------------!>


<table class=\"table\" width=\"80%\">
<tr>
<td>
<strong>Know Your Client</strong>
</td>
</tr>

<tr>
<td class=\"td2\" colspan=\"3\">Source - How did you meet?&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientmeetmethod\" value=\"Referral\"> Referral&nbsp;&nbsp;
<input type=\"radio\" name=\"clientmeetmethod\" value=\"Personal Contact\"> Personal Contact&nbsp;&nbsp;
<input type=\"radio\" name=\"clientmeetmethod\" value=\"Seminar\"> Seminar&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientmeetmethod\" value=\"Advertising\"> Advertising&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientmeetmethod\" value=\"Phone In\"> Phone In&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientmeetmethod\" value=\"Walk In\"> Walk In
</td>
</tr>


<tr>
<td class=\"td2\" colspan=\"2\">
Known Client Since:&nbsp;&nbsp; <input type=\"text\" value=\"".$pdata['clientknowndate']."\" name=\"clientknowndate\" size=20>
&nbsp;&nbsp; or &nbsp;&nbsp;&nbsp;<input type=\"text\" value=\"".$pdata['clientknownyears']."\" name=\"clientknownyears\" size=4> &nbsp;&nbsp;years
</td>
<td class=\"td2\">
Investor Citizenship <input type=\"text\" value=\"".$pdata['clientcitizenship']."\" name=\"clientcitizenship\" size=10>
<BR />
</td>
</tr>


<tr>
<td class=\"td2\" colspan=\"2\">
Investor Occupation
<input type=\"text\" value=\"".$pdata['clientoccupation']."\" name=\"clientoccupation\" size=30>
</td>
<td class=\"td2\">
Investor Employer
<input type=\"text\" value=\"".$pdata['clientemployer']."\" name=\"clientemployer\" size=40>
</td>
</tr>


<tr>
<td class=\"td2\" colspan=\"2\">
Employer Address
<input type=\"text\" value=\"".$pdata['clientemployeraddress']."\" name=\"clientemployeraddress\" size=40>
</td>
<td class=\"td2\">
Business Type
<input type=\"text\" value=\"".$pdata['clientemployerbusinesstype']."\" name=\"clientemployerbusinesstype\" size=50>
</td>
</tr>


<tr>
<td class=\"td2\" colspan=\"3\">Marital Status&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientmaritalstatus\" value=\"Single\"> Single&nbsp;&nbsp;
<input type=\"radio\" name=\"clientmaritalstatus\" value=\"Married\"> Married&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientmaritalstatus\" value=\"Common Law\"> Common Law&nbsp;&nbsp;
<input type=\"radio\" name=\"clientmaritalstatus\" value=\"Seperated\"> Seperated&nbsp;&nbsp;
<input type=\"radio\" name=\"clientmaritalstatus\" value=\"Divorced\"> Divorced&nbsp;&nbsp;
<input type=\"radio\" name=\"clientmaritalstatus\" value=\"Widowed\"> Widowed
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
Number of Dependants <input type=\"text\" value=\"".$pdata['clientnumberofdependants']."\" name=\"clientnumberofdependants\" size=4>
</td>
</tr>


<tr>
<td class=\"td2\" colspan=\"3\">ID Verification (check one)&nbsp;&nbsp;&nbsp;
<input type=\"radio\" name=\"clientidverification\" value=\"Passport\"> Passport
<input type=\"radio\" name=\"clientidverification\" value=\"Birth Certificate\"> Birth Certificate
<input type=\"radio\" name=\"clientidverification\" value=\"Drivers License\"> Driver's License
<input type=\"radio\" name=\"clientidverification\" value=\"Immigration Card\"> Immigration Card
<input type=\"radio\" name=\"clientidverification\" value=\"Other\"> Other 
</td>
</tr>


<tr>
<td class=\"td2\">
ID Number
<input type=\"text\" value=\"".$pdata['clientidnumber']."\" name=\"clientidnumber\" size=40>
</td>
<td class=\"td2\">
ID Expiry Date
<input type=\"text\" value=\"".$pdata['clientidexpirydate']."\" name=\"clientidexpirydate\" size=50>
</td>
<td class=\"td2\">
ID Issue Country/Province
<input type=\"text\" value=\"".$pdata['clientidissuecountryprovince']."\" name=\"clientidissuecountryprovince\" size=50>
</td>
</tr>


<tr>
<td class=\"td2\">
Financial Institution
<input type=\"text\" value=\"".$pdata['clientfinancialinstitution']."\" name=\"clientfinancialinstitution\" size=40>
</td>
<td class=\"td2\">
Transit# / Account#
<input type=\"text\" value=\"".$pdata['clienttransitaccountnumber']."\" name=\"clienttransitaccountnumber\" size=50>
</td>
<td class=\"td2\">
Currency
<input type=\"text\" value=\"".$pdata['clientcurrency']."\" name=\"clientcurrency\" size=50>
</td>
</tr>


<tr>
<td class=\"td2\">
Investor Income
<input type=\"text\" value=\"".$pdata['clientinvestorincome']."\" name=\"clientinvestorincome\" size=40>
</td>
<td class=\"td2\">
Investor Net Worth
<input type=\"text\" value=\"".$pdata['clientinvestornetworth']."\" name=\"clientinvestornetworth\" size=50>
</td>
<td class=\"td2\" colspan=\"3\">Investment Knowledge (check one)&nbsp;&nbsp;&nbsp;<BR />
<input type=\"radio\" name=\"clientinvestmentknowledge\" value=\"Sophisticated\"> Sophisticated
<input type=\"radio\" name=\"clientinvestmentknowledge\" value=\"Good\"> Good
<input type=\"radio\" name=\"clientinvestmentknowledge\" value=\"Fair\"> Fair
<input type=\"radio\" name=\"clientinvestmentknowledge\" value=\"Poor\"> Poor
</td>
</tr>

<tr>
<td class=\"td2\"  colspan=3>
	<table class=\"table\" cellspacing=\"0\" cellpadding=\"0\">
	<tr>
	<td class=\"td2\">
	Joint Investor Occupation 
	</td>
	<td class=\"td2\">
	Joint Investor Employer 
	</td>
	<td class=\"td2\">
	Joint Income
	</td>
	<td class=\"td2\">
	Joint Net Worth
	</td>
	</tr>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientcoinvestoroccupation']."\" name=\"clientcoinvestoroccupation\" size=50>
	</td>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientcoinvestoremployer']."\" name=\"clientcoinvestoremplyer\" size=40>
	</td>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientjointincome']."\" name=\"clientjointincome\" size=20>
	</td>
	<td class=\"td2\">
	<input type=\"text\" value=\"".$pdata['clientjointnetworth']."\" name=\"clientjointnetworth\" size=20>
	</td>
	</table>
</td>
</tr>


</table>



<BR />
<BR />
<BR />


<table class=\"table\" width=\"80%\">
<tr>
<td>
<strong>Complete</strong>
</td>
</tr>

<tr>
<td class=\"td2\">
<input type=\"checkbox\" name=\"complete\" value=\"complete\">
</td>
</tr>
</table>
















<BR />


<input type=\"submit\" value=\"Create\" name=\"submit\"><BR />
</form>








<BR />
<BR />
<BR />
<BR />
<BR />
<BR />
<BR />";















?>















