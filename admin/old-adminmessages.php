<?php



include('includes/adminpostclean.php');

include('includes/adminsession.php');

include('includes/adminhtmlhead.php');

include('includes/adminbanner.php');





//why is this block so short?	
if( isset($_POST['usermessage']) ){
	$error = '';
	$pdata = $_POST;

	////// error handling

	//include generic $_POST cleaner
	$pdata = hash_mysql_sanitize($pdata);

	echo "<H2>Messaging</H2>
	
	<b>Sending new message to \"".$pdata['username']."\":</b>

	<BR />
	<form action=\"adminmessages.php\" method=\"post\">
	<input type=\"hidden\" name=\"username\" value=\"".$pdata['username']."\">
	<textarea name=\"message\"></textarea><BR />
	<input type=\"submit\" name=\"submitusermessage\">
	
	</form>
	</body>
	</html>";
	
	die();
		
}


//convert to messages
if( isset($_POST['submitusermessage']) ){

//clean $_POST
	
//process errors here, after the header is printed.
if( $error ){
	echo "<font color=\"red\"><b>$error</b></font><BR />";
	//we just print the page like normal, if there are errors.
}
else{

	//grab the default expire time from the core table
	$data = mysql_fetch_array(mysql_query('SELECT * FROM core WHERE id = 1'));
	
	mysql_query('INSERT INTO messages (
		`message`,
		`age`)
		VALUES ("'.$_POST['message'].'",
			"'.$data['message_scrubtime'].'")');

	echo "The message has been successfully sent.";	
	echo "<meta http-equiv=\"refresh\" content=\"3;\">";
	die();
}

}


echo "<H2>Messaging</H2>";
	
if( !(isset($_POST['usermessage'])) || !(isset($_POST['globalmessage'])) ){

	$rawusernamedata = mysql_query('SELECT `username` FROM `users`');

	echo "<b>New message to user:</b>
	<form action=\"adminmessages.php\" method=\"post\">
	<select name=\"username\">";

	//put a value in a drop-down menu for each user
	//so that we can select one
	while( $cleanusernamedata = mysql_fetch_array($rawusernamedata) ){
		echo "<option name=\"username\" value=\"".$cleanusernamedata['username']."\">".$cleanusernamedata['username']."</option>";
	}
	echo "</select><BR />
	<input type=\"submit\" name=\"usermessage\" value=\"Select User\">
	</form>";

	echo "<b>New global message:</b>
	<form action=\"adminmessages.php\" method=\"post\">
	<input type=\"submit\" name=\"globalmessage\" value=\"Submit\">
	</form>
	</body>
	</html>";
	die();
	
}



?>















