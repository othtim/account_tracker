<?php

session_start();

//sanitary functions
include('includes/adminpostclean.php');

//include the admin redirect and unauthenticated users stuff
include('includes/adminsession.php');

include('includes/adminbanner.php');

?>

<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<TITLE>home</TITLE>
<LINK rel="stylesheet" type="text/css" href="includes/styles.css" />
</HEAD>

<BODY>

<?php



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !empty($_POST['submit']) ){
	$error = '';
	$pdata = $_POST;
	$pdata = hash_mysql_sanitize($pdata);



	//check if a user with that clientname already exists
	if( mysql_num_rows( mysql_query('SELECT * FROM `profile` WHERE `clientname` = "'.$pdata['clientname'].'"') ) ){
		$error .= "The company \"".$pdata['clientname']."\" already exists! <BR />";
	}


	//make sure no empty values are submitted
	foreach( $pdata as $key => $value ){

		if( preg_match("/(^$)|(^\s$)/",$value) ){
			$error .= '"'.$key.'" contained no data! <BR />';
		}
	}

}
	


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




if( !empty($pdata['submit']) ){

	//process errors here, after the header is printed.
	if( $error ){
		echo "<font color=\"red\"><b>$error</b></font><BR />";
		//we just print the page like normal, if there are errors.
	}
	else{
		
		//start populating the database with the submitted values
		$query = sprintf('INSERT INTO `profile` (`clientname`,`company_name`,`company_address`,`company_phone`,`company_fax`,`contact1_name`,`contact1_phone1`,`contact1_phone2`,`contact1_fax`) VALUES("%s","%s","%s","%s","%s","%s","%s","%s","%s")',
				mysql_real_escape_string($pdata['clientname']),
				mysql_real_escape_string($pdata['Company_Name']),
				mysql_real_escape_string($pdata['Company_Address']),
				mysql_real_escape_string($pdata['Company_Phone']),
				mysql_real_escape_string($pdata['Company_Fax']),
				mysql_real_escape_string($pdata['Contact1_Name']),
				mysql_real_escape_string($pdata['Contact1_Phone1']),
				mysql_real_escape_string($pdata['Contact1_Phone2']),
				mysql_real_escape_string($pdata['Contact1_Fax']));
		mysql_query($query);
		

		//the user was successfully created.
		echo "The user was successfully created. <BR />";
		echo "<meta http-equiv=\"refresh\" content=\"3\">";
		die();
			
	}

//no errors begin here.
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//to avoid errors related to pdata not being set. fix later? 	
$pdata=1;



echo "<form action=\"admincreate.php\" method=\"post\">

<H1>Create a New Account</H1>






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
<input type=\"text\" value=\"".$pdata['clientdealernumber']."\" name=\"dealernumber\" size=\"10\">
</td>

<td class=td2>
Advisor Number
<BR />
<input type=\"text\" value=\"".$pdata['clientadvisornumber']."\" name=\"advisornumber\" size=\"10\">
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
Transit# / Account#
<input type=\"text\" value=\"".$pdata['clienttransitaccountnumber']."\" name=\"clienttransitaccountnumber\" size=50>
</td>
<td class=\"td2\">
Currency
<input type=\"text\" value=\"".$pdata['clientcurrency']."\" name=\"clientcurrency\" size=50>
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















