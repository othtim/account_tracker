<?php

session_start();

//sanitary functions
include('includes/adminpostclean.php');

include('includes/adminsession.php');

//mysql_connect('localhost','root','shadow');
//mysql_select_db('stest');

?>

<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<TITLE>View Profile</TITLE>
<LINK rel="stylesheet" type="text/css" href="includes/styles.css" />
</HEAD>

<BODY>


<?php

include('includes/adminbanner.php');


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

















//////////////////////////////////////////////////////////////////////////////////HTML CONTENT AREA
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$profiledata=1;

echo "<form action=\"adminviewprofile.php\" method=\"post\">
<input type=\"hidden\" name=\"clientname\" value=\"".$profiledata['clientname']."\">";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////we need a function here output the data in a nice way.
//




echo "<TABLE width=1000 class=table>";


////////////////////////Start by printing the columns
//
$query = sprintf('SELECT thisfieldname from `fields`');
$fieldsdata = mysql_query($query);

echo "<TR>";
while($fieldsdatarow = mysql_fetch_row($fieldsdata)){

	for($i=0;$i < count($fieldsdatarow);$i++){

		echo "<TD class=td1>";
		echo $fieldsdatarow[$i]. "<BR />";	
		echo "</TD>";

	}


}
echo "</TR>";


////////////////////////Then print user data
//
$query = sprintf('SELECT * FROM profile');
$clientdata = mysql_query($query);

//for each record, print the data in a spreadsheet style
while($clientdatarow = mysql_fetch_row($clientdata)){

	echo "<TR>";

	for($i=0;$i < count($clientdatarow);$i++){

		echo "<TD class=td2>";
		echo $clientdatarow[$i]. "<BR />";	
		echo "</TD>";

	}

	echo "</TR><BR>";
}



echo "</TABLE>";





/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





// assemble

$teststring='|b=clientcity|b=clientcity|n|b=clientcity|b=clientcity|';
$cutstring = 0;
$cutstring = explode("|", $teststring);



// iterate

for($i=0;$i < sizeof($cutstring);$i++){


	// we are matching a box.
	//
	if( preg_match("/^b=(.+)$/", $cutstring[$i], $matches) ){
		
		$query = sprintf('SELECT %s FROM profile', $matches[1]);
		$clientdata = mysql_fetch_array(mysql_query($query));

		echo $clientdata . "<BR />";	
	}


}





?>















