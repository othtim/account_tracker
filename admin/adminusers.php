<?php


include('includes/adminsession.php');

include('includes/adminhtmlhead.php');

include('includes/adminbanner.php');


$pdata=$_POST;


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
// Add a new user
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( isset($pdata['adduser']) ){

	echo "
	<form action=\"adminusers.php\" method=\"post\" name=\"dunno\">
	<table>
	<tr>
		<td class=\"td1\" width=10%>
		Username:
		</td>
		<td class=\"td2\" width=30%>
		<input type=\"text\" value=\"\" name=\"username\"> 
		</td>
	</tr>
	<tr>
		<td class=\"td1\" width=10%>
		Password:
		</td>
		<td class=\"td2\" width=30%>
		<input type=\"text\" value=\"\" name=\"password\"> 
		</td>
	</tr>
	<tr>
		<td class=\"td1\" width=10%>
		Security:
		</td>
		<td class=\"td2\" width=30%>
		<input type=\"text\" value=\"\" name=\"security\"> 
		</td>
	</tr>
	</table>
	<input type=\"hidden\" name=\"addsubmit\" value=\"yes\">
	<input type=\"submit\" name=\"submit\" value=\"Submit\">
	</form>
	<HR />
	";

}else if( isset($pdata['addsubmit']) ){

	$query = sprintf("INSERT INTO `users` (`username`,`password`,`date_registered`,`last_seen`,`security`) VALUES ('%s','%s','%s','%s','%s')",$pdata['username'],$pdata['password'],time(),time(),0);
	$result = mysql_query($query);

	$result = mysql_error();
	echo $result;

}else if( isset($pdata['updateuser']) ){

	$query = sprintf("UPDATE `users` SET username='%s',password='%s',date_registered='%s',last_seen='%s',security='%s' WHERE `username`='%s'", $pdata['username'], $pdata['password'], $pdata['date_registered'], $pdata['last_seen'], $pdata['security'],$pdata['username']);
	$result = mysql_query($query);

	$result = mysql_error();
	echo $result;

}

echo" 	<H2>Users</H2>
	<form action=\"adminusers.php\" method=\"post\">
	<input type=\"submit\" name=\"adduser\" value=\"Add User\">
	</form>
	<HR />
	";



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>






<?php 


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//declare and populate an array with the names of the columns in the profile table
//
$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='users'";
$userscolumndata = mysql_query($query) or die(mysql_error());

echo "<table class=\"table\" width=\"60%\">";
echo "<TR>";

while($userscolumndata_this=mysql_fetch_row($userscolumndata) ){

	echo "<td>$userscolumndata_this[0]</td>";
}

echo "</TR>";	






//grab all of the information from the fields table.
$userstable = sprintf('SELECT * FROM `users`');
$userstable = mysql_query($userstable); 

//for each record, print the field information in a spreadsheet style
while($usersrow = mysql_fetch_row($userstable)){

	echo "
	<form action=\"adminusers.php\" method=\"post\" name=\"dunno\">

	<tr>

	<td class=\"td1\" width=30%>
	" . $usersrow[0] . "
	</td>

	<td class=\"td1\" width=30%>
	<input type=\"text\" value=\"" . $usersrow[1] . "\" name=\"username\">
	</td>

	<td class=\"td2\"width=30%>
	<input type=\"text\" value=\"" . $usersrow[2] . "\" name=\"password\">
	</td>

	<td class=\"td2\"width=5%>
	<input type=\"text\" value=\"" . $usersrow[3] . "\" name=\"date_registered\">
	</td>

	<td class=\"td2\"width=5%>
	<input type=\"text\" value=\"" . $usersrow[4] . "\" name=\"last_seen\">
	</td>

	<td class=\"td2\"width=5%>
	<input type=\"text\" value=\"" . $usersrow[5] . "\" name=\"security\">
	</td>

	<td class=\"td2\"width=5%>
	<input type=\"hidden\" name=\"updateuser\" value=\"yes\">
	<input type=\"submit\" value=\"Update\" name=\"submit\">
	</td>

	</tr>

	</form>
	";

}

echo "</table>";


$pdata['adduser'] ='';
$pdata['addsubmit'] ='';
$pdata['updateuser'] ='';


?>














