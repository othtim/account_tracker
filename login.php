<?php
session_start();

mysql_connect('localhost','root','test');
mysql_select_db('stest');

?>

<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<TITLE>Log In</TITLE>
</HEAD>
<BODY>

<?php

	
if( isset($_POST['login']) ){
	$error = '';
	
	//do I really trust this?
	//$username = addslashes($_POST['username']);	
	//$password = addslashes($_POST['password']); 

	//make sure only letters and numbers are present.
	if( preg_match('/[^A-Za-z0-9[:space:]]/',$_POST['username']) || preg_match('/[^A-Za-z0-9[:space:]]/',$_POST['password']) ){
		$error .= '<meta http-equiv="refresh" content="0;url=login.php"/>';
		echo $error;
		die();
	}
	else{
		$username = addslashes($_POST['username']);
		$password = addslashes($_POST['password']);
	}
	
	if( !isset($username) || !isset($password) ){
		$error .= 'A required field was left blank.<BR />';
	}

	//passwords are stored as md5.
	$password = $password; // md5($password);
	
	$query = sprintf("SELECT * FROM `users` WHERE `username` ='%s' AND `password` ='%s'", $username, $password);
	$result = mysql_query($query);


	//if mysql_num_rows() returns 1, then the query passed.
	$valid_login = mysql_num_rows($result);
	if($valid_login == 0){
		$error .= 'The supplied username and/or password was incorrect. <BR />';
	}

	if( !($error) ){
			
		$data = mysql_fetch_array($result);
		
		//gateway to the admin portal if this var is set to 'admin'.
		$_SESSION['username'] = $data['username'];

		//unix epoch
		$_SESSION['time'] = time();

		mysql_query(' 
			UPDATE `users` SET `last_seen`="'.time().'" WHERE `username`="'.$username.'" ');

		//provision for the administrator account
		if($_SESSION['username'] == 'admin'){
			echo '<meta http-equiv="Refresh" Content="0; URL=admin/adminhome.php">';
			die();
		}
			
		echo '<meta http-equiv="Refresh" Content="0; URL=user/userhome.php">';
		die();
	}
	else{
		echo 'The following errors were returned: <BR /><font color="red"><b>'.$error.'</b></font><BR />';
	}
}

?>

<form action="login.php" method="post">
Username: <input type="text" name="username" /><BR />
Password: <input type="password" name="password" /><BR />

<input name="login" type="submit" value="Log In"><BR />
</form>

</BODY>
</HTML>










		












		
