<?php

//we have to start the session so we know what we have to remove
session_start();

$_SESSION['username']='';

//unset the cookie
if( isset( $_COOKIE[session_name()])){

	//unset the cookie associated with this session
	setcookie(session_name(), '', time()-42000, '/');
}
session_destroy();
?>

<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<TITLE>Log Out</TITLE>
</HEAD>
<BODY>

<?php

	echo "You have successfully been logged out.<BR />";
	echo '<meta http-equiv="Refresh" content="3; URL=../login.php">';
	
?>
	
</BODY>
</HTML>










		












		
