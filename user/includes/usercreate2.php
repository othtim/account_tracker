<?php

include("includes/adminfiles.php") || die("header not found!");
	
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<TITLE>home</TITLE>
</HEAD>

<BODY>

<?php

//we want to execute this whether it's the first or second run
if( isset($_POST['submit']) ){
	$error = '';
	$pdata = $_POST;

	
////// error handling

	//make sure only alphanumerics are submitted
	foreach( $pdata as $key => $value ){
	
		if( preg_match("/[^a-zA-Z0-9\s]/",$value) ){
			$error .= '"'.$key.'" contained invalid characters! All fields must be alphanumeric. <BR />';
		}
	}

	//make sure no empty values are submitted
	foreach( $pdata as $key => $value ){

		if( preg_match("/(^$)|(^\s$)/",$value) ){
			$error .= '"'.$key.'" contained no data! <BR />';
		}
	}

	//check if the password match
	if( $pdata['Password'] == $pdata['Password2'] ){
		//we're good, do nothing.
	}
	else{
		//no good, throw an error
		$error .= "The passwords do not match.";
	}

	//check if a user with that username already exists
	if( mysql_num_rows( mysql_query('SELECT * FROM `users` WHERE `username` = "'.$pdata['Username'].'"') ) ){
		//username already exists!
		$error .= "The user \"".$pdata['Username']."\" already exists! <BR />";
	}
}
	
//pull the user data so we can tell the user when they last logged in
$data = mysql_fetch_array( mysql_query('SELECT * FROM `users` WHERE `username` LIKE "'.$_SESSION['username'].'"'));

echo "Welcome back, ".$_SESSION['username'].". <BR />";
echo "Your last login was ".date('l, F j, Y', $data['last_seen']).". <BR />";
echo "<HR />";
echo "<a href=\"adminhome.php\">Home</a> | <a href=\"admincore.php\">Core</a> | <a href=\"admincreate.php\">Create</a> | <a href=\"adminprofile.php\">Profile</a> | <a href=\"admincomponents.php\">Components</a> | <a href=\"logout.php\">Logout</a>";
echo "<HR />";


if( isset($pdata['submit']) ){
	

//process errors here, after the header is printed.
if( $error ){
	echo "<font color=\"red\"><b>$error</b></font><BR />";
	//we just print the page like normal, if there are errors.
}
else{
	
	//start populating the database with the submitted values
	$pdata['Password'] = md5($pdata['Password']);

		
	//insert the user data
	mysql_query('INSERT INTO `users` 
	(`username`, 
	 `password`, 
	 `date_registered`, 
	 `last_seen`) 
	 VALUES("'.$pdata['Username'].'", 
	        "'.$pdata['Password'].'", 
		"'.time().'", 
		"'.time().'")');

	//insert the contact information
	mysql_query('INSERT INTO `profile`
	(`username`,
	 `company_name`,
	 `company_address`,
	 `company_phone`,
	 `company_fax`,
	 `contact1_name`,
	 `contact1_phone1`,
	 `contact1_phone2`,
	 `contact1_fax`) 
	 VALUES("'.$pdata['Username'].'",
	 	"'.$pdata['Company_Name'].'",
		"'.$pdata['Company_Address'].'",
		"'.$pdata['Company_Phone'].'",
		"'.$pdata['Company_Fax'].'",
		"'.$pdata['Contact1_Name'].'",
		"'.$pdata['Contact1_Phone1'].'",
		"'.$pdata['Contact1_Phone2'].'",
		"'.$pdata['Contact1_Fax'].'")');

	//the user was successfully created.
	echo "The user was successfully created. <BR />";
	die();
			
}

}
	

echo "<form action=\"admincreate.php\" method=\"post\">

<H2>Create a New Account</H2>


<a name=\"user\"></a>
Please enter a username for this account: 
<input type=\"text\" value=\"".$pdata['Username']."\" name=\"Username\"><BR />
Please enter a password for this account: 
<input type=\"password\" name=\"Password\"><BR />
Please re-enter the password:
<input type=\"password\" name=\"Password2\"><BR />

<HR />

<a name=\"profile\"></a>

Company Name:
<input type=\"text\" value=\"".$pdata['Company_Name']."\" name=\"Company_Name\"><BR />
Company Address
<input type=\"text\" value=\"".$pdata['Company_Address']."\" name=\"Company_Address\"><BR />
Company Phone:
<input type=\"text\" value=\"".$pdata['Company_Phone']."\" name=\"Company_Phone\"><BR />
Company Fax:
<input type=\"text\" value=\"".$pdata['Company_Fax']."\" name=\"Company_Fax\"><BR />

<BR />
Contact Name:
<input type=\"text\" value=\"".$pdata['Contact1_Name']."\" name=\"Contact1_Name\"><BR />
Contact Phone1:
<input type=\"text\" value=\"".$pdata['Contact1_Phone1']."\" name=\"Contact1_Phone1\"><BR />
Contact Phone2:
<input type=\"text\" value=\"".$pdata['Contact1_Phone2']."\" name=\"Contact1_Phone2\"><BR />
Contact Fax:
<input type=\"text\" value=\"".$pdata['Contact1_Fax']."\"name=\"Contact1_Fax\"><BR />
<BR />
<input type=\"submit\" value=\"Create\" name=\"submit\"><BR />
</form>";














?>















